<?php

namespace App\Http\Livewire\InhouseTraining;

use App\Models\InhouseTrainingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination, LivewireAlert;

    public $search;
    public $jenis = 'all';
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshInhouseTrainingTable' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = InhouseTrainingRequest::with('user.fasyankes')
            ->where(function ($query) {
                $query->where('no_surat', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_kegiatan', 'like', '%' . $this->search . '%');
            })
            ->when($this->jenis != 'all', function ($query) {
                $query->where('stts', $this->jenis);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.inhouse-training.table', [
            'requests' => $data,
        ]);
    }

    public function kirimEmail($id)
    {
        $request = InhouseTrainingRequest::with('user.fasyankes')->find($id);
        $email = $request->user->fasyankes->email ?? $request->user->email ?? null;

        if (!$request || !$email) {
            $this->alert('error', 'Email tujuan tidak ditemukan');
            return;
        }

        if ($request->stts !== 'disetujui') {
            $this->alert('warning', 'Surat belum disetujui');
            return;
        }

        try {
            Mail::send('emails.inhouse-training', [
                'requestInhouse' => $request,
                'messageText' => $this->messageText($request),
            ], function ($message) use ($request, $email) {
                $message->to($email)
                    ->subject('Surat Inhouse Training - ' . ($request->nama_kegiatan ?? 'Inhouse Training'));

                if ($request->file_balasan) {
                    $message->attach(storage_path('app/public/inhouse-training-balasan/' . $request->file_balasan), [
                        'as' => 'Surat-Balasan-Inhouse-Training.pdf',
                        'mime' => 'application/pdf',
                    ]);
                }

                if ($request->file_tugas) {
                    $message->attach(storage_path('app/public/inhouse-training-tugas/' . $request->file_tugas), [
                        'as' => 'Surat-Tugas-Inhouse-Training.pdf',
                        'mime' => 'application/pdf',
                    ]);
                }
            });

            $this->alert('success', 'Email berhasil dikirim');
        } catch (\Throwable $th) {
            $this->alert('error', 'Email gagal dikirim: ' . $th->getMessage());
        }
    }

    public function kirimWa($id)
    {
        $request = InhouseTrainingRequest::with('user.fasyankes')->find($id);
        $phone = $this->normalizePhone($request->user->fasyankes->telp ?? '');

        if (!$request || !$phone) {
            $this->alert('error', 'Nomor WA tujuan tidak ditemukan');
            return;
        }

        if ($request->stts !== 'disetujui') {
            $this->alert('warning', 'Surat belum disetujui');
            return;
        }

        $message = $this->messageText($request);
        $token = config('services.fonnte.token');

        if ($token) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                ])->asForm()->post(config('services.fonnte.url'), [
                    'target' => $phone,
                    'message' => $message,
                ]);

                if ($response->successful()) {
                    $this->alert('success', 'WA berhasil dikirim via Fonnte');
                    return;
                }

                $this->alert('error', 'WA gagal dikirim via Fonnte: ' . $response->body());
                return;
            } catch (\Throwable $th) {
                $this->alert('error', 'WA gagal dikirim via Fonnte: ' . $th->getMessage());
                return;
            }
        }

        $this->dispatchBrowserEvent('openWa', [
            'url' => 'https://wa.me/' . $phone . '?text=' . rawurlencode($message),
        ]);
    }

    private function messageText($request)
    {
        $fasyankes = $request->user->fasyankes ?? null;

        return "Yth. " . ($fasyankes->nama ?? $request->user->name ?? 'Bapak/Ibu') . ",\n\n"
            . "Surat balasan dan surat tugas untuk kegiatan " . ($request->nama_kegiatan ?? 'Inhouse Training') . " telah diterbitkan.\n\n"
            . "Validasi surat balasan: " . route('inhouse-training.surat.validasi', ['requestInhouse' => $request->id, 'type' => 'balasan']) . "\n"
            . "Validasi surat tugas: " . route('inhouse-training.surat.validasi', ['requestInhouse' => $request->id, 'type' => 'tugas']) . "\n\n"
            . "Terima kasih.";
    }

    private function normalizePhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            return '62' . substr($phone, 1);
        }

        return $phone;
    }
}
