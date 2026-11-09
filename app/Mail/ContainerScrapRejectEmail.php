<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContainerScrapRejectEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $containerScrap;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($containerScrap)
    {
        $this->containerScrap = $containerScrap;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Container Scrap Reject Email')->markdown('mail.scrap-reject-email')->with('containerScrap', $this->containerScrap);
    }
}
