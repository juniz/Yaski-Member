<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order_id;
    public $workshop;
    public $nama;
    public $pesanan;
    public $total;
    public $jml;
    public $harga;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $workshop, $nama, $pesanan, $total, $jml, $harga)
    {
        $this->order_id = $order_id;
        $this->workshop = $workshop;
        $this->nama = $nama;
        $this->pesanan = $pesanan;
        $this->total = $total;
        $this->jml = $jml;
        $this->harga = $harga;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Notifikasi Pembayaran Workshop',
            from: 'noreply.khanzaindonesia@gmail.com',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.mail',
            with: [
                'order_id' => $this->order_id,
                'workshop' => $this->workshop,
                'nama' => $this->nama,
                'pesanan' => $this->pesanan,
                'total' => $this->total,
                'jml' => $this->jml,
                'harga' => $this->harga,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
