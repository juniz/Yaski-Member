<?php

namespace App\Http\Livewire;

use App\Exports\SertifikatExport;
use App\Services\CertificateGeneratorService;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Sertifikat;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class SertifikatTable extends DataTableComponent
{
    protected $model = Sertifikat::class;
    public $idWorkshop;

    public function mount($idWorkshop)
    {
        $this->idWorkshop = $idWorkshop;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {
        return Sertifikat::query()
            ->join('peserta', 'peserta.id', '=', 'sertifikat.peserta_id')
            ->join('workshop', 'workshop.id', '=', 'sertifikat.workshop_id')
            ->leftJoin('transaction', 'transaction.id', '=', 'peserta.transaction_id')
            ->where('workshop.id', $this->idWorkshop)
            ->select(
                'sertifikat.*',
                'peserta.nama as peserta_nama',
                'workshop.nama as workshop_nama',
                'transaction.nama_rs'
            );
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export Excel',
            'generateSelected' => 'Generate Sertifikat Terpilih',
        ];
    }

    public function export()
    {
        return Excel::download(new SertifikatExport($this->idWorkshop), 'sertifikat.xlsx');
    }

    public function generateSelected()
    {
        $selected = $this->getSelected();
        if (empty($selected)) {
            $this->emit('alert', ['type' => 'warning', 'message' => 'Pilih sertifikat terlebih dahulu']);
            return;
        }

        $service = new CertificateGeneratorService();
        $success = 0;
        $failed = 0;

        foreach ($selected as $id) {
            try {
                $result = $service->generate($id);
            } catch (\Throwable $e) {
                Log::error('Gagal generate sertifikat terpilih', [
                    'workshop_id' => $this->idWorkshop,
                    'sertifikat_id' => $id,
                    'message' => $e->getMessage(),
                ]);
                $result = null;
            }

            if ($result) {
                $success++;
            } else {
                $failed++;
            }
        }

        $this->clearSelected();
        $this->emit('alert', ['type' => 'success', 'message' => "Generate selesai: {$success} berhasil, {$failed} gagal"]);
    }

    public function generateSingle($id)
    {
        $service = new CertificateGeneratorService();
        $result = $service->generate($id);

        if ($result) {
            $this->emit('alert', ['type' => 'success', 'message' => 'Sertifikat berhasil di-generate']);
        } else {
            $this->emit('alert', ['type' => 'error', 'message' => 'Gagal generate sertifikat. Pastikan template sudah diupload.']);
        }
    }

    public function columns(): array
    {
        return [
            Column::make("No urut", "no_urut")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('no_urut', $direction);
                }),
            Column::make("Tgl Checkin", "created_at")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('created_at', $direction);
                }),
            Column::make("No sertifikat", "no_sertifikat")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('no_sertifikat', $direction);
                })
                ->searchable(),
            Column::make("Nama", "nama")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('sertifikat.nama', $direction);
                })
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    // Tampilkan nama sertifikat, jika kosong fallback ke nama peserta
                    $nama = $value ?: $row->peserta_nama;
                    if (!$value) {
                        return '<span class="text-muted">' . e($nama) . '</span> <span class="badge bg-secondary">dari pendaftaran</span>';
                    }
                    return e($nama);
                })
                ->html(),
            Column::make("Instansi", "instansi")
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('sertifikat.instansi', $direction);
                })
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    $instansi = $value ?: $row->nama_rs;
                    if (!$value) {
                        return '<span class="text-muted">' . e($instansi) . '</span> <span class="badge bg-secondary">dari pendaftaran</span>';
                    }
                    return e($instansi);
                })
                ->html(),
            Column::make("Sertifikat", "file_sertifikat")
                ->format(function ($value, $row, Column $column) {
                    if ($value) {
                        $previewUrl = url('sertifikat/' . $row->id . '/preview');
                        $downloadUrl = url('sertifikat/' . $row->id . '/download');
                        return '
                        <div class="btn-group btn-group-sm">
                            <a href="' . $previewUrl . '" target="_blank" class="btn btn-info btn-sm" title="Preview">
                                <i class="bx bx-show"></i>
                            </a>
                            <a href="' . $downloadUrl . '" class="btn btn-success btn-sm" title="Download">
                                <i class="bx bx-download"></i>
                            </a>
                        </div>';
                    }
                    return '<span class="badge bg-warning text-dark">Belum Generate</span>';
                })
                ->html(),
            Column::make("Aksi", "id")
                ->format(function ($value, $row, Column $column) {
                    return '
                    <button wire:click="generateSingle(\'' . $value . '\')" class="btn btn-primary btn-sm" title="Generate Sertifikat">
                        <i class="bx bx-refresh"></i> Generate
                    </button>';
                })
                ->html(),
        ];
    }
}
