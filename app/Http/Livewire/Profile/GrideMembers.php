<?php

namespace App\Http\Livewire\Profile;

use App\Models\Paklaring;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class GrideMembers extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert;
    public $pakelaring, $file, $idUser, $search;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshMembers' => '$refresh', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.profile.gride-members', [
            'members' => User::where('name', 'like', '%' . $this->search . '%')->paginate(10),
        ]);
    }

    public function mount()
    {
        // $this->getMembers();
    }

    public function status($id)
    {
        $paklaring = Paklaring::where('user_id', $id)->where('stts', 'disetujui')->first();
        $mou = \App\Models\Mou::where('user_id', $id)->where('stts', 'disetujui')->first();
        if ($paklaring && $mou) {
            return true;
        } else {
            return false;
        }
    }

    public function kwitansi($id)
    {
        $customer = new Buyer([
            'name'          => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item);

        $link = $invoice->url();

        return response()->streamDownload(function () use ($invoice) {
            echo  $invoice->stream();
        }, 'invoice.pdf');
    }

    public function confirmDelete($id)
    {
        $this->confirm('Apakah anda yakin ingin menghapus data ini?', [
            'onConfirmed' => 'delete',
            'inputAttributes' => ['id' => $id],
        ]);
    }

    public function delete($data)
    {
        $id = $data['data']['inputAttributes']['id'];
        try {
            $user = User::find($id);
            $user->delete();
            Storage::delete('public/avatar/' . $user->avatar);
            $this->emit('refreshMembers');
            $this->alert('success', 'Berhasil menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error', 'Gagal menghapus data', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }

    public function modalPakelaring($id)
    {
        $this->idUser = $id;
        $this->getPakelaring($id);
        if ($this->pakelaring) {
            $this->dispatchBrowserEvent('modalPakelaring');
        } else {
            $this->alert('warning', 'Pakelaring belum diupload', [
                'position' =>  'center',
                'toast' =>  false,
            ]);
        }
    }

    public function getPakelaring($id)
    {
        $this->pakelaring = Paklaring::where('user_id', $id)->first();
    }

    public function simpan()
    {
        $this->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ], [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa pdf',
            'file.max' => 'File maksimal 2MB',
        ]);

        try {
            Storage::delete('public/pakelaring/' . $this->pakelaring->file);
            $fileName = 'PF-' . time() . '.' . $this->file->extension();
            $this->file->storeAs('public/pakelaring', $fileName);
            $this->pakelaring->update([
                'file' => $fileName,
                'stts' => '1'
            ]);
            $this->getPakelaring($this->idUser);
            $this->dispatchBrowserEvent('swal', ['title' => 'Berhasil', 'type' => 'success', 'text' => 'Pakelaring berhasil diupload']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal', ['title' => 'Gagal', 'type' => 'error', 'text' => 'Pakelaring gagal diupload' . $e->getMessage()]);
        }
    }
}
