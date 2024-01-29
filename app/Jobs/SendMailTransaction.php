<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendMailTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
        $data = $this->data;
        $beautymail->send('emails.welcome', [
            'name' => $data['nama'],
            'qr' => $data['qr'],
        ], function ($message) use ($data) {
            $message
                ->from('noreplay@yaski.com')
                ->to($data['email'], $data['nama'])
                ->subject('Bukti Pendaftaran Workshop YASKI');
        });
    }
}
