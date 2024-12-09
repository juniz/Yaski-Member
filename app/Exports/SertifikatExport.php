<?php

namespace App\Exports;

use App\Models\Sertifikat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Transaction;
use App\Models\Peserta;

class SertifikatExport implements FromCollection, WithHeadings, WithMapping
{
    public $workshop;

    public function __construct($workshop)
    {
        $this->workshop = $workshop;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Sertifikat::where('workshop_id', $this->workshop)
            ->orderBy('no_urut', 'asc')
            ->selectRaw("no_urut, no_sertifikat, nama, instansi, CONCAT('https://yaskimember.org/sertifikat/', id, '/validasi') as url, peserta_id, workshop_id")
            ->get();
    }

    public function headings(): array
    {
        return [
            'No urut',
            'No sertifikat',
            'Nama',
            'Instansi',
            'Url',
        ];
    }

    public function map($invoice): array
    {
        // dd($invoice);
        return [
            $invoice->no_urut,
            $invoice->no_sertifikat,
            $invoice->nama ?? Peserta::where('id', $invoice->peserta_id)->first()->nama,
            $invoice->instansi ?? Transaction::where('workshop_id', $invoice->workshop_id)->first()->nama_rs,
            $invoice->url,
        ];
    }
}
