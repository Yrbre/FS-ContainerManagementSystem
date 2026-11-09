<?php

namespace App\Http\Livewire\WAService;

use App\Services\WhatspieService;
use Livewire\Component;

class ButtonAction extends Component
{
    public $status;

    public function mount(WhatspieService $whatspieService)
    {
        $body = $whatspieService->getStatus();
        $responseData = json_decode($body, true);
        if (!$responseData) {
            $this->status = 'NOT CONNECTED';
        } else {
            $this->status = $responseData['state'];
        }
    }
    public function render()
    {
        return view('livewire.w-a-service.button-action');
    }
}
