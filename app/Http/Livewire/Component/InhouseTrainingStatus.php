<?php

namespace App\Http\Livewire\Component;

use App\Models\InhouseTrainingRequest;
use Livewire\Component;

class InhouseTrainingStatus extends Component
{
    public $requestsInhouse;

    protected $listeners = ['refreshInhouseTraining' => 'getRequestInhouse'];

    public function render()
    {
        return view('livewire.component.inhouse-training-status');
    }

    public function getRequestInhouse()
    {
        $this->requestsInhouse = InhouseTrainingRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
