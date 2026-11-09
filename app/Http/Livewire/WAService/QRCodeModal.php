<?php

namespace App\Http\Livewire\WAService;

use App\Services\WhatspieService;
use Livewire\Component;

class QRCodeModal extends Component
{
    public $qrcode;
    public $errorMessage;

    public function mount(WhatspieService $waService)
    {
        $response = $waService->fetchQRCode();

        if ($response['success']) {
            $this->qrcode = $response['qrcode'];
            $this->errorMessage = null;
        } else {
            $this->qrcode = null;
            $this->errorMessage = $response['message'];
        }
    }
    public function render()
    {
        return view('livewire.w-a-service.q-r-code-modal');
    }
}
