<?php

namespace App\Http\Livewire\Profile;

use App\Models\InhouseTrainingRequest;
use Livewire\Component;

class RiwayatInhouseTraining extends Component
{
    public $requestsInhouse;

    public function render()
    {
        return view('livewire.profile.riwayat-inhouse-training');
    }

    public function getRequestInhouse()
    {
        $this->requestsInhouse = InhouseTrainingRequest::where('user_id', auth()->id())
            ->latest()
            ->get();
    }
}
