<?php

namespace App\Exports;

use App\Models\Peserta;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PesertaExport implements FromCollection, WithHeadings
{
    public $workshop;
    public $status;

    public function __construct($workshop, $status)
    {
        $this->workshop = $workshop;
        $this->status = $status;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->status == '') {
            return Transaction::join('peserta', 'transaction.id', '=', 'peserta.transaction_id')
                ->where('transaction.workshop_id', $this->workshop)
                ->orderBy('transaction.order_id', 'asc')
                ->select('transaction.order_id', 'peserta.nama', 'transaction.stts', 'transaction.nama_rs', 'peserta.jns_kelamin', 'peserta.email', 'peserta.telp', 'peserta.baju', 'peserta.paket', 'peserta.harga')
                ->get();
        } else {
            return Transaction::join('peserta', 'transaction.id', '=', 'peserta.transaction_id')
                ->where('transaction.workshop_id', $this->workshop)
                ->where('peserta.stts', $this->status)
                ->orderBy('transaction.order_id', 'asc')
                ->select('transaction.order_id', 'peserta.nama', 'transaction.stts', 'transaction.nama_rs', 'peserta.jns_kelamin', 'peserta.email', 'peserta.telp', 'peserta.baju', 'peserta.paket', 'peserta.harga')
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'order id',
            'nama',
            'status',
            'nama rs',
            'jns kelamin',
            'email',
            'telp',
            'baju',
            'paket',
            'harga'
        ];
    }
}
