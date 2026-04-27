<?php

namespace App\Http\Livewire;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class KwitansiTable extends DataTableComponent
{
    protected $model = Peserta::class;

    public string $idWorkshop;

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
        return Peserta::query()
            ->join('transaction', 'transaction.id', '=', 'peserta.transaction_id')
            ->leftJoin('sertifikat', function ($join) {
                $join->on('sertifikat.peserta_id', '=', 'peserta.id')
                    ->on('sertifikat.workshop_id', '=', 'transaction.workshop_id');
            })
            ->where('transaction.workshop_id', $this->idWorkshop)
            ->where('transaction.stts', 'dibayar')
            ->orderByRaw('CASE WHEN sertifikat.no_urut IS NULL OR sertifikat.no_urut = "" THEN 1 ELSE 0 END ASC')
            ->orderByRaw('CAST(sertifikat.no_urut AS UNSIGNED) ASC')
            ->orderBy('transaction.order_id', 'asc')
            ->select(
                'peserta.*',
                'transaction.order_id',
                'transaction.nama_rs',
                'transaction.stts',
                'sertifikat.no_urut as sertifikat_no_urut'
            );
    }

    public function columns(): array
    {
        return [
            Column::make('No. Urut', 'sertifikat_no_urut')
                ->format(fn ($value) => e($value ?: '-'))
                ->html()
                ->sortable(function (Builder $builder, $direction) {
                    return $builder
                        ->orderByRaw('CASE WHEN sertifikat.no_urut IS NULL OR sertifikat.no_urut = "" THEN 1 ELSE 0 END ' . $direction)
                        ->orderByRaw('CAST(sertifikat.no_urut AS UNSIGNED) ' . $direction);
                })
                ->searchable(),
            Column::make('No. Order', 'transaction.order_id')
                ->sortable()
                ->searchable(),
            Column::make('Nama Peserta', 'nama')
                ->sortable()
                ->searchable(),
            Column::make('Instansi', 'transaction.nama_rs')
                ->format(fn ($value) => e($value ?: 'Pribadi'))
                ->html()
                ->sortable()
                ->searchable(),
            Column::make('Paket', 'paket')
                ->sortable()
                ->searchable(),
            Column::make('Nominal', 'harga')
                ->format(fn ($value) => 'Rp ' . number_format((int) $value, 0, ',', '.'))
                ->sortable(),
            Column::make('Status', 'transaction.stts')
                ->format(fn ($value) => ucfirst($value ?? '-'))
                ->sortable(),
            Column::make('Aksi', 'id')
                ->format(function ($value) {
                    $printUrl = route('kwitansi.cetak', $value);
                    $validasiUrl = route('kwitansi.validasi', $value);

                    return '
                    <div class="btn-group btn-group-sm">
                        <a href="' . $printUrl . '" target="_blank" class="btn btn-success" title="Cetak Kwitansi">
                            <i class="bx bx-printer"></i> Cetak
                        </a>
                        <a href="' . $validasiUrl . '" target="_blank" class="btn btn-outline-primary" title="Validasi QR">
                            <i class="bx bx-check-shield"></i>
                        </a>
                    </div>';
                })
                ->html(),
        ];
    }
}
