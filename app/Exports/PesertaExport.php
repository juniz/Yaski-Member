<?php

namespace App\Exports;

use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaExport implements FromCollection
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
        return Peserta::join('transaction', 'transaction.id', '=', 'peserta.transaction_id')
            ->where('transaction.workshop_id', $this->workshop)
            ->orderBy('transaction.order_id', 'asc')
            ->select('peserta.*', 'transaction.order_id', 'transaction.nama_rs', 'transaction.kd_rs')
            ->get();
    }
}
