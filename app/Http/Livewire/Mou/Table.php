<?php

namespace App\Http\Livewire\Mou;

use Livewire\Component;
use App\Models\Mou;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $search, $jenis = 'all';
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshMou' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->jenis == 'all') {
            $data = Mou::where('no_surat', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $data = Mou::where('no_surat', 'like', '%' . $this->search . '%')->where('stts', $this->jenis)->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('livewire.mou.table', [
            'mous' => $data
        ]);
    }
}
