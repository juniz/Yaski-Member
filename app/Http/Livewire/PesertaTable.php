<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PesertaExport;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class PesertaTable extends DataTableComponent
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
        $this->setPrimaryKey('id');
        $this->setFiltersStatus(true);
    }

    public function builder(): Builder
    {
        return Peserta::query()
            ->join('transaction', 'transaction.id', '=', 'peserta.transaction_id')
            ->where('transaction.workshop_id', $this->idWorkshop)
            ->orderBy('transaction.order_id', 'asc')
            ->select('peserta.*', 'transaction.order_id', 'transaction.nama_rs', 'transaction.kd_rs', 'transaction.stts', 'peserta.stts as stts_peserta');
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Tanggal Transaksi')
                ->filter(function (Builder $builder, string $value) {
                    $builder->whereDate('transaction.created_at', Date::parse($value)->format('Y-m-d'));
                }),
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua',
                    'menunggu' => 'Menunggu',
                    'kadaluarsa' => 'kadaluarsa',
                    'dibatalkan' => 'Dibatalkan',
                    'dibayar' => 'Dibayar',
                    'batal' => 'Batal',
                ])
                ->filter(function (Builder $builder, $value) {
                    $this->status = $value;
                    if ($value === '') {
                        return;
                    } else if ($value === 'batal') {
                        $builder->where('transaction.stts', $value);
                    } else {
                        $builder->where('transaction.stts', $value);
                    }
                }),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
        ];
    }

    public function export()
    {
        return Excel::download(new PesertaExport($this->idWorkshop, $this->status), 'peserta.xlsx');
    }

    public function batal($id)
    {
        $peserta = Peserta::find($id);
        $peserta->stts = 'batal';
        $peserta->save();
        $this->emit('refreshDatatable');
    }

    public function generateSertifikat($nama)
    {
        // dd($nama);
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile(storage_path('app/public/templates/sertifikat/template.pdf'));
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(105, 100);
        $pdf->Cell(0, 0, $nama, 0, 1, 'C');
        $pdf->SetXY(105, 110);
        $pdf->Cell(0, 0, 'Sertifikat', 0, 1, 'C');
        $pdf->Output('S', 'Sertifikat-' . $nama . '.pdf', true);
    }

    public function columns(): array
    {
        return [
            Column::make("No. Order", "transaction.order_id")
                ->sortable()
                ->searchable(),
            Column::make("Nama Peserta", "nama")
                ->sortable()
                ->searchable(),
            Column::make("Status", "transaction.stts")
                ->format(function ($value, $row, Column $column) {
                    if ($row->stts_peserta == 'batal') {
                        return 'Batal';
                    } else {
                        return Str::ucfirst($value);
                    }
                })
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
            // Column::make("Kode RS", "transaction.kd_rs")
            //     ->sortable(),
            Column::make("Jenis Kelamin", "jns_kelamin")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Telp", "telp")
                ->sortable(),
            Column::make("Baju", "baju")
                ->sortable(function (Builder $query, $direction) {
                    $query->orderBy('baju', $direction);
                }),
            Column::make("Paket", "paket")
                ->sortable(),
            Column::make("Harga", "harga")
                ->sortable(),
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
                            <li><a class="dropdown-item" data-bs-toggle="modal" wire:click="batal(' . $value . ')" 
                                    href="#">Batal</a></li>
                            <li><a class="dropdown-item" href="' . $url . '"
                            >Sertifikat</a></li>
                        </ul>
                    </div>
                    ';
                })
                ->html(),
        ];
    }
}
