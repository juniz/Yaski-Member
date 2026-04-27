<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\Transaction;
use App\Services\CertificateGeneratorService;

class RiwayatWorkshop extends Component
{
    public $transactions = [];
    public $selectedWorkshop = null;
    public $selectedTransaction = null;
    public $selectedSertifikats = [];
    public $selectedCheckinPeserta = null;
    public $checkinMessage = null;
    public $checkinType = 'success';
    protected $listeners = ['load-riwayat-workshop' => 'getWorkshop'];

    public function render()
    {
        return view('livewire.profile.riwayat-workshop');
    }

    public function showMateri($workshopId)
    {
        $this->selectedWorkshop = \App\Models\Workshop::with('materials')->find($workshopId);
        $this->dispatchBrowserEvent('openMateriModal');
    }

    public function showSertifikat($transactionId)
    {
        $this->selectedTransaction = Transaction::with(['workshop', 'peserta'])->find($transactionId);

        if (!$this->selectedTransaction) {
            $this->selectedSertifikats = collect();
            $this->dispatchBrowserEvent('openSertifikatModal');
            return;
        }

        $pesertaIds = $this->selectedTransaction->peserta->pluck('id');
        $this->selectedSertifikats = Sertifikat::with('peserta')
            ->where('workshop_id', $this->selectedTransaction->workshop_id)
            ->whereIn('peserta_id', $pesertaIds)
            ->orderBy('no_urut')
            ->get();

        $this->dispatchBrowserEvent('openSertifikatModal');
    }

    public function showBuktiCheckin($pesertaId)
    {
        $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();

        $this->selectedCheckinPeserta = Peserta::with(['transaction.workshop'])
            ->where('id', $pesertaId)
            ->where('stts', 'hadir')
            ->whereHas('transaction', function ($query) use ($fasyankes) {
                $query->where('kd_rs', $fasyankes->kode ?? '-')
                    ->where('stts', 'dibayar');
            })
            ->first();

        $this->dispatchBrowserEvent('openBuktiCheckinModal');
    }

    public function getWorkshop()
    {
        $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();
        $this->transactions = Transaction::with(['workshop.materials', 'peserta'])
            ->where('kd_rs', $fasyankes->kode ?? '-')
            ->where('stts', 'dibayar')
            ->get();
    }

    public function checkInPeserta($pesertaId)
    {
        $this->checkinMessage = null;
        $fasyankes = \App\Models\Fasyankes::where('user_id', auth()->user()->id)->first();

        $peserta = Peserta::with(['transaction.workshop'])
            ->where('id', $pesertaId)
            ->whereHas('transaction', function ($query) use ($fasyankes) {
                $query->where('kd_rs', $fasyankes->kode ?? '-')
                    ->where('stts', 'dibayar');
            })
            ->first();

        if (!$peserta || !$peserta->transaction || !$peserta->transaction->workshop) {
            $this->checkinType = 'danger';
            $this->checkinMessage = 'Data peserta tidak ditemukan atau tidak dapat melakukan check-in.';
            return;
        }

        if ($peserta->stts === 'hadir') {
            $this->checkinType = 'info';
            $this->checkinMessage = $peserta->nama . ' sudah check-in.';
            return;
        }

        $peserta->stts = 'hadir';
        $peserta->save();

        $workshopId = $peserta->transaction->workshop_id;
        $sertifikat = Sertifikat::where('workshop_id', $workshopId)
            ->where('peserta_id', $peserta->id)
            ->first();

        if (!$sertifikat) {
            $noUrut = (int) Sertifikat::where('workshop_id', $workshopId)->max('no_urut') + 1;
            $no = sprintf('%03d', $noUrut);
            $sertifikat = Sertifikat::create([
                'workshop_id' => $workshopId,
                'peserta_id' => $peserta->id,
                'no_sertifikat' => date('Y') . '/YASKI/' . date('m') . '/' . $no,
                'no_urut' => $no,
                'nama' => $peserta->nama,
                'instansi' => $peserta->transaction->nama_rs,
            ]);
        }

        try {
            (new CertificateGeneratorService())->generate($sertifikat->id);
        } catch (\Exception $e) {
            \Log::warning('Gagal generate sertifikat check-in mandiri: ' . $e->getMessage());
        }

        $this->checkinType = 'success';
        $this->checkinMessage = 'Check-in berhasil untuk ' . $peserta->nama . '.';
        $this->getWorkshop();
    }

    public function bayar($id)
    {
        try {
            $transaction = Transaction::find($id);
            $peserta = Peserta::where('transaction_id', $id)->get();
            $peserta->each(function ($p) {
                $p->update(['transaction_id' => null]);
            });
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
}
