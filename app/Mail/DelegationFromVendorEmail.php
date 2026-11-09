<?php

namespace App\Mail;

use App\Models\ContainerDelegationFromVendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DelegationFromVendorEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $containerDelegationFromVendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        $this->containerDelegationFromVendor = $containerDelegationFromVendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('BAST From Vendor Email')->markdown('mail.delegation-from-vendor-notification-email')->with('containerDelegationFromVendor', $this->containerDelegationFromVendor);
    }
}
