<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\ContainerDelegation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DelegationToVendorRejectEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $containerDelegation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContainerDelegation $containerDelegation)
    {
        $this->containerDelegation = $containerDelegation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('BAST To Vendor Reject Email')->markdown('mail.delegation-rejected-email')->with('containerDelegation', $this->containerDelegation);
    }
}
