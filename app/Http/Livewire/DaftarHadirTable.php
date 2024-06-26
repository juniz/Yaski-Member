<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Date;
use App\Models\Peserta;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Sertifikat;
use PDF;

class DaftarHadirTable extends DataTableComponent
{
    public string $idWorkshop;
    public string $status = '';
    protected $model = Peserta::class;

    public function mount($idWorkshop)
    {
        $this->idWorkshop = $idWorkshop;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTrAttributes(function ($model) {
                if ($model->stts == 'hadir') {
                    return ['class' => 'table-success'];
                } else {
                    return [];
                }
            });
        $this->setFiltersStatus(true);
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua',
                    'hadir' => 'Hadir',
                    'belum hadir' => 'Belum Hadir',
                    'tidak hadir' => 'Tidak Hadir',
                ])
                ->filter(function (Builder $builder, $value) {
                    $this->status = $value;
                    if ($value === '') {
                        return;
                    } else {
                        $builder->where('peserta.stts', $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        return Peserta::query()
            ->join('transaction', 'transaction.id', '=', 'peserta.transaction_id')
            // ->leftJoin('daftar_hadir', 'daftar_hadir.peserta_id', '=', 'peserta.id')
            ->where('transaction.workshop_id', $this->idWorkshop)
            ->where('transaction.stts', 'dibayar')
            ->orderBy('transaction.order_id', 'asc')
            ->select('peserta.*', 'transaction.order_id', 'transaction.nama_rs', 'transaction.kd_rs');
    }

    public function hadir($data)
    {
        // dd($data);
        // $id = Crypt::encrypt($data['id']);
        $workshop = \App\Models\Workshop::find($this->idWorkshop);
        $peserta = Peserta::find($data['id']);
        $peserta->stts = 'hadir';
        $peserta->save();
        $cek = Sertifikat::where('workshop_id', $this->idWorkshop)->where('peserta_id', $data['id'])->first();
        $idSertifikat = $cek->id ?? null;
        if (!$cek) {
            $no_urut = Sertifikat::where('workshop_id', $this->idWorkshop)->max('no_urut') + 1;
            $no = sprintf("%03d", $no_urut);
            $no_sertifikat = date('Y') . '/' . 'YASKI' . '/' . date('m') . '/' . $no;
            $sertifikat = Sertifikat::create([
                'workshop_id' => $this->idWorkshop,
                'peserta_id' => $data['id'],
                'no_sertifikat' => $no_sertifikat,
                'no_urut' => $no,
            ]);
            $idSertifikat = $sertifikat->id;
        }
        $this->emit('refreshDatatable');
        $pdf = PDF::loadView('prints.labels.peserta', ['data' => $data, 'url' => url('sertifikat/' . $idSertifikat), 'workshop' => $workshop->nama, 'no_urut' => $no ?? $cek->no_urut]);
        Storage::put('public/labels/' . $this->idWorkshop . '/' . $peserta->nama . '.pdf', $pdf->output());
        $this->emit('openLabel', [
            'nama' => $peserta->nama,
            'url' => url('storage/labels/' . $this->idWorkshop . '/' . $peserta->nama . '.pdf')
        ]);
    }

    public function tidakHadir($data)
    {
        $peserta = Peserta::find($data['id']);
        $peserta->stts = 'tidak hadir';
        $peserta->save();
        $cek = Sertifikat::where('workshop_id', $this->idWorkshop)->where('peserta_id', $data['id'])->first();
        if ($cek) {
            $cek->delete();
            @unlink(storage_path('app/public/labels/' . $this->idWorkshop . '/' . $peserta->nama . '-' . $cek->no_urut . '.pdf'));
        }
        $this->emit('refreshDatatable');
    }

    public function columns(): array
    {
        return [
            Column::make("Order ID", "transaction.order_id")
                ->sortable()
                ->searchable(),
            Column::make("Nama", "nama")
                ->sortable()
                ->searchable(),
            Column::make("Nama RS", "transaction.nama_rs")
                ->format(function ($value, $row, Column $column) {
                    if ($row->transaction->kd_rs) {
                        $fasyankes = \App\Models\Fasyankes::where('kode', $row->transaction->kd_rs)->first();
                        $paklaring = \App\Models\Paklaring::where('user_id', $fasyankes->belongUser->id ?? '-')->where('stts', 'disetujui')->first();
                        $mou = \App\Models\Mou::where('user_id', $fasyankes->belongUser->id ?? '-')->where('stts', 'disetujui')->first();
                        if ($paklaring && $mou) {
                            return '
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                  </svg>
                            ' . $value;
                        } else {
                            return $value;
                        }
                    }
                    return 'Pribadi';
                })
                ->html()
                ->sortable()
                ->searchable(),
            Column::make("Jns kelamin", "jns_kelamin")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Telp", "telp")
                ->sortable(),
            Column::make("Baju", "baju")
                ->sortable(),
            Column::make("Paket", "paket")
                ->sortable(),
            Column::make("Harga", "harga")
                ->sortable(),
            Column::make("Stts", "stts")
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 'Belum Hadir';
                }),
            Column::make("Aksi", "id")
                ->format(function ($value, $row, Column $column) {
                    $nama = "'" . $row->nama . "'";
                    $url = url('sertifikat/' . $row->nama);
                    return '
                    <div class="dropdown">
                        <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" data-bs-toggle="modal" wire:click="hadir(' . $row . ')" 
                                    href="#">Check In</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" wire:click="tidakHadir(' . $row . ')" 
                                    href="#">Batal</a></li>
                        </ul>
                    </div>
                    ';
                })
                ->html(),
        ];
    }
}
