<?php

namespace App\Http\Livewire\Paklaring;

use Livewire\Component;
use App\Models\Paklaring;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $search, $jenis = 'all';
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshPaklaring' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->jenis == 'all') {
            $data = Paklaring::where('no_surat', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $data = Paklaring::where('no_surat', 'like', '%' . $this->search . '%')->where('stts', $this->jenis)->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('livewire.paklaring.table', [
            'paklarings' => $data
        ]);
    }
}
