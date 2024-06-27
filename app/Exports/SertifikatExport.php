<?php

namespace App\Exports;

use App\Models\Sertifikat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SertifikatExport implements FromCollection, WithHeadings
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
            ->selectRaw("no_urut, no_sertifikat, nama, instansi, CONCAT('https://yaskimember.org/sertifikat/', id, '/validasi') as url")
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
}
