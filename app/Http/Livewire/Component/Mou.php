<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Mou as MouModel;

class Mou extends Component
{
    public $file_pertama;
    public $file_kedua;
    public $stts;
    public $alasan;

    protected $listeners = ['refreshMou' => 'getMou'];
    public function render()
    {
        return view('livewire.component.mou');
    }

    public function getMou()
    {
        $data = MouModel::where('user_id', auth()->user()->id)->first();
        $this->file_pertama = $data->file_pertama ?? '';
        $this->file_kedua = $data->file_kedua ?? '';
        $this->stts = $data->stts ?? '';
    }
}
