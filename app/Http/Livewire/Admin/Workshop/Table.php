<?php

namespace App\Http\Livewire\Admin\Workshop;

use Livewire\Component;
use App\Models\Workshop;

class Table extends Component
{
    protected $listeners = ['refreshWorkshop' => '$refresh'];
    public function render()
    {
        return view('livewire.admin.workshop.table', [
            'workshops' => Workshop::all()
        ]);
    }
}
