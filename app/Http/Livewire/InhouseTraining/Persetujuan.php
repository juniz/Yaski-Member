<?php

namespace App\Http\Livewire\InhouseTraining;

use App\Models\InhouseTrainingRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Persetujuan extends Component
{
    use LivewireAlert;

    public ?InhouseTrainingRequest $requestInhouse = null;
    public $alasan;

    public $no_surat_balasan;
    public $no_surat_tugas;
    public $tanggal_surat;
    public $kepada;
    public $kota_tujuan;
    public $perihal;
    public $tanggal_kegiatan;
    public $petugas_text;
    public $transport_nominal = 'Disediakan Pihak Mengundang';
    public $penginapan_nominal = 'Disediakan Pihak Mengundang';
    public $honor_nominal = 'Menyesuaikan aturan Honor Narasumber yang diterbitkan oleh Rumah Sakit mengacu Peraturan Menteri Keuangan Republik Indonesia Nomor 39 Tahun 2024 Standar Biaya Masukan Pada Honorarium Narasumber kegiatan Tahun 2025.';

    public $manual_user_id;
    public $manual_fasyankes;
    public $manual_tujuan_mode = 'registered';
    public $manual_nama_kegiatan;
    public $manual_no_surat;
    public $manual_tgl_surat;

    protected $listeners = ['modalInhouseTraining', 'docInhouseTraining', 'editSuratInhouseTraining', 'openManualInhouseTraining'];

    public function render()
    {
        return view('livewire.inhouse-training.persetujuan', [
            'users' => User::with('fasyankes')->orderBy('name')->get(),
        ]);
    }

    public function openManualInhouseTraining()
    {
        $this->resetValidation();
        $this->manual_user_id = null;
        $this->manual_fasyankes = null;
        $this->manual_tujuan_mode = 'registered';
        $this->manual_nama_kegiatan = null;
        $this->manual_no_surat = null;
        $this->manual_tgl_surat = date('Y-m-d');
        $this->dispatchBrowserEvent('openManualInhouseTraining');
    }

    public function updatedManualTujuanMode()
    {
        $this->resetValidation(['manual_user_id', 'manual_fasyankes']);
        $this->manual_user_id = null;
        $this->manual_fasyankes = null;
    }

    public function simpanManual()
    {
        if ($this->manual_tujuan_mode === 'registered') {
            $this->manual_fasyankes = null;
        } else {
            $this->manual_user_id = null;
        }

        $this->validate([
            'manual_tujuan_mode' => 'required|in:registered,freetext',
            'manual_user_id' => 'nullable|exists:users,id',
            'manual_fasyankes' => 'nullable',
            'manual_nama_kegiatan' => 'required',
            'manual_tgl_surat' => 'required|date',
        ], [
            'manual_nama_kegiatan.required' => 'Nama kegiatan tidak boleh kosong',
            'manual_tgl_surat.required' => 'Tanggal tidak boleh kosong',
        ]);

        try {
            $userId = $this->manual_user_id ?: auth()->id();
            $this->requestInhouse = InhouseTrainingRequest::create([
                'user_id' => $userId,
                'nama_kegiatan' => $this->manual_nama_kegiatan,
                'no_surat' => $this->manual_no_surat ?: 'Tanpa Surat Permintaan',
                'tgl_surat' => $this->manual_tgl_surat,
                'file' => '',
                'stts' => 'proses',
                'data_surat' => [
                    'manual_fasyankes' => $this->manual_fasyankes,
                    'manual_user_id' => $this->manual_user_id,
                    'manual_tujuan_mode' => $this->manual_tujuan_mode,
                ],
            ]);

            $this->setDefaultSurat();
            $this->emit('refreshInhouseTrainingTable');
            $this->dispatchBrowserEvent('manualInhouseTrainingCreated');
            $this->alert('success', 'Permintaan manual berhasil dibuat. Silakan generate surat.');
        } catch (\Throwable $th) {
            $this->alert('error', 'Permintaan manual gagal dibuat\n' . $th->getMessage());
        }
    }

    public function modalInhouseTraining(InhouseTrainingRequest $requestInhouse)
    {
        $this->requestInhouse = $requestInhouse;
        $this->setDefaultSurat();
        $this->dispatchBrowserEvent('modalInhouseTraining');
    }

    public function docInhouseTraining(InhouseTrainingRequest $requestInhouse)
    {
        $this->requestInhouse = $requestInhouse;
        $this->dispatchBrowserEvent('docInhouseTraining');
    }

    public function editSuratInhouseTraining(InhouseTrainingRequest $requestInhouse)
    {
        $this->requestInhouse = $requestInhouse;
        $this->setDefaultSurat();
        $this->dispatchBrowserEvent('editSuratInhouseTraining');
    }

    public function simpanSetuju()
    {
        $this->validate([
            'no_surat_balasan' => 'required',
            'no_surat_tugas' => 'required',
            'tanggal_surat' => 'required|date',
            'kepada' => 'required',
            'kota_tujuan' => 'required',
            'perihal' => 'required',
            'tanggal_kegiatan' => 'required|date',
            'petugas_text' => 'required',
        ], [
            'no_surat_balasan.required' => 'Nomor surat balasan tidak boleh kosong',
            'no_surat_tugas.required' => 'Nomor surat tugas tidak boleh kosong',
            'tanggal_surat.required' => 'Tanggal surat tidak boleh kosong',
            'kepada.required' => 'Tujuan surat tidak boleh kosong',
            'kota_tujuan.required' => 'Kota tujuan tidak boleh kosong',
            'perihal.required' => 'Perihal tidak boleh kosong',
            'tanggal_kegiatan.required' => 'Tanggal kegiatan tidak boleh kosong',
            'petugas_text.required' => 'Nama PIC atau petugas tidak boleh kosong',
        ]);

        try {
            $petugas = $this->parsePetugas();
            $dataSurat = [
                'no_surat_balasan' => $this->no_surat_balasan,
                'no_surat_tugas' => $this->no_surat_tugas,
                'tanggal_surat' => $this->tanggal_surat,
                'kepada' => $this->kepada,
                'kota_tujuan' => $this->kota_tujuan,
                'perihal' => $this->perihal,
                'bulan_kegiatan' => $this->formatBulanKegiatan($this->tanggal_kegiatan),
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'petugas' => $petugas,
                'transport_nominal' => $this->transport_nominal,
                'penginapan_nominal' => $this->penginapan_nominal,
                'honor_nominal' => $this->honor_nominal,
                'manual_fasyankes' => $this->requestInhouse->data_surat['manual_fasyankes'] ?? null,
                'manual_user_id' => $this->requestInhouse->data_surat['manual_user_id'] ?? null,
                'manual_tujuan_mode' => $this->requestInhouse->data_surat['manual_tujuan_mode'] ?? null,
            ];

            $balasanFileName = 'BALASAN-INHOUSE-' . $this->requestInhouse->id . '-' . time() . '.pdf';
            $tugasFileName = 'SURAT-TUGAS-INHOUSE-' . $this->requestInhouse->id . '-' . time() . '.pdf';
            $qrBalasan = $this->makeQrCode(route('inhouse-training.surat.validasi', [
                'requestInhouse' => $this->requestInhouse->id,
                'type' => 'balasan',
            ]));
            $qrTugas = $this->makeQrCode(route('inhouse-training.surat.validasi', [
                'requestInhouse' => $this->requestInhouse->id,
                'type' => 'tugas',
            ]));

            $balasanPdf = PDF::loadView('prints.inhouse-training.balasan', [
                'requestInhouse' => $this->requestInhouse,
                'dataSurat' => $dataSurat,
                'qrCode' => $qrBalasan,
            ])->setPaper('a4', 'portrait');

            $tugasPdf = PDF::loadView('prints.inhouse-training.surat-tugas', [
                'requestInhouse' => $this->requestInhouse,
                'dataSurat' => $dataSurat,
                'qrCode' => $qrTugas,
            ])->setPaper('a4', 'portrait');

            Storage::put('public/inhouse-training-balasan/' . $balasanFileName, $balasanPdf->output());
            Storage::put('public/inhouse-training-tugas/' . $tugasFileName, $tugasPdf->output());

            if ($this->requestInhouse->file_balasan && file_exists(storage_path('app/public/inhouse-training-balasan/' . $this->requestInhouse->file_balasan))) {
                @unlink(storage_path('app/public/inhouse-training-balasan/' . $this->requestInhouse->file_balasan));
            }
            if ($this->requestInhouse->file_tugas && file_exists(storage_path('app/public/inhouse-training-tugas/' . $this->requestInhouse->file_tugas))) {
                @unlink(storage_path('app/public/inhouse-training-tugas/' . $this->requestInhouse->file_tugas));
            }

            $this->requestInhouse->update([
                'file_balasan' => $balasanFileName,
                'file_tugas' => $tugasFileName,
                'data_surat' => $dataSurat,
                'stts' => 'disetujui',
                'alasan' => null,
            ]);

            $this->emit('refreshInhouseTrainingTable');
            $this->dispatchBrowserEvent('simpanPersetujuanInhouseTraining');
            $this->alert('success', 'Permintaan inhouse training berhasil disetujui');
        } catch (\Throwable $th) {
            $this->alert('error', 'Permintaan inhouse training gagal disetujui\n' . $th->getMessage());
        }
    }

    public function simpanTolak()
    {
        $this->validate([
            'alasan' => 'required',
        ], [
            'alasan.required' => 'Alasan tidak boleh kosong',
        ]);

        try {
            $this->requestInhouse->update([
                'alasan' => $this->alasan,
                'stts' => 'ditolak',
            ]);

            $this->emit('refreshInhouseTrainingTable');
            $this->reset('alasan');
            $this->dispatchBrowserEvent('simpanPersetujuanInhouseTraining');
            $this->alert('success', 'Permintaan inhouse training berhasil ditolak');
        } catch (\Throwable $th) {
            $this->alert('error', 'Permintaan inhouse training gagal ditolak\n' . $th->getMessage());
        }
    }

    private function setDefaultSurat()
    {
        $fasyankes = $this->requestInhouse->user->fasyankes ?? null;
        $manualFasyankes = $this->requestInhouse->data_surat['manual_fasyankes'] ?? null;
        $this->tanggal_surat = $this->requestInhouse->data_surat['tanggal_surat'] ?? date('Y-m-d');
        $this->no_surat_balasan = $this->requestInhouse->data_surat['no_surat_balasan'] ?? $this->generateNomorSurat(0, $this->tanggal_surat);
        $this->no_surat_tugas = $this->requestInhouse->data_surat['no_surat_tugas'] ?? $this->generateNomorSurat(1, $this->tanggal_surat);
        $this->kepada = $this->requestInhouse->data_surat['kepada'] ?? ($manualFasyankes ?: ($fasyankes->nama ?? $this->requestInhouse->user->name ?? ''));
        $this->kota_tujuan = $this->requestInhouse->data_surat['kota_tujuan'] ?? ($fasyankes->kabupaten->name ?? '');
        $this->perihal = $this->requestInhouse->data_surat['perihal'] ?? ($this->requestInhouse->nama_kegiatan ?? 'Pendampingan Inhouse Training');
        $this->tanggal_kegiatan = $this->requestInhouse->data_surat['tanggal_kegiatan'] ?? '';
        $this->petugas_text = $this->requestInhouse->data_surat['petugas_text'] ?? $this->formatPetugasText($this->requestInhouse->data_surat['petugas'] ?? []);
        $this->transport_nominal = $this->requestInhouse->data_surat['transport_nominal'] ?? $this->transport_nominal;
        $this->penginapan_nominal = $this->requestInhouse->data_surat['penginapan_nominal'] ?? $this->penginapan_nominal;
        $this->honor_nominal = $this->requestInhouse->data_surat['honor_nominal'] ?? $this->honor_nominal;
    }

    private function parsePetugas()
    {
        return collect(preg_split('/\r\n|\r|\n/', $this->petugas_text))
            ->filter(fn($line) => trim($line) !== '')
            ->values()
            ->map(function ($line) {
                $parts = array_map('trim', explode('|', $line, 2));

                return [
                    'nama' => $parts[0] ?? '',
                    'kontak' => $parts[1] ?? '',
                ];
            })
            ->all();
    }

    private function formatPetugasText($petugas)
    {
        return collect($petugas)
            ->map(function ($item) {
                return trim(($item['nama'] ?? '') . (!empty($item['kontak']) ? ' | ' . $item['kontak'] : ''));
            })
            ->filter()
            ->implode("\n");
    }

    private function generateNomorSurat($offset = 0, $tanggal = null)
    {
        $year = date('Y', strtotime($tanggal ?? date('Y-m-d')));
        $month = (int) date('n', strtotime($tanggal ?? date('Y-m-d')));
        $romanMonth = $this->romanMonth($month);

        $lastNumber = InhouseTrainingRequest::whereNotNull('data_surat')
            ->get()
            ->flatMap(function ($request) {
                return [
                    $request->data_surat['no_surat_balasan'] ?? null,
                    $request->data_surat['no_surat_tugas'] ?? null,
                ];
            })
            ->filter()
            ->map(function ($number) {
                preg_match('/^(\d+)/', $number, $matches);
                return isset($matches[1]) ? (int) $matches[1] : 0;
            })
            ->max() ?? 0;

        return sprintf('%03d/YASKI/%s/%s', $lastNumber + 1 + $offset, $romanMonth, $year);
    }

    private function formatBulanKegiatan($tanggal)
    {
        $month = (int) date('n', strtotime($tanggal));
        $year = date('Y', strtotime($tanggal));

        return 'Bulan ' . $this->namaBulan($month) . ' ' . $year;
    }

    private function namaBulan($month)
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ][$month] ?? 'Januari';
    }

    private function romanMonth($month)
    {
        return [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ][$month] ?? 'I';
    }

    private function makeQrCode($url)
    {
        $svg = QrCode::format('svg')->size(360)->margin(1)->errorCorrection('H')->generate($url);

        $logoPath = public_path('assets/images/logo.png');
        if (file_exists($logoPath)) {
            $logo = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            $overlay = '
                <rect x="133" y="133" width="94" height="94" rx="8" ry="8" fill="#ffffff"/>
                <image href="' . $logo . '" x="143" y="143" width="74" height="74" preserveAspectRatio="xMidYMid meet"/>
            ';
            $svg = str_replace('</svg>', $overlay . '</svg>', $svg);
        }

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
