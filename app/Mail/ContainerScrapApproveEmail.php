<?php

namespace App\Mail;

use App\Models\ContainerScrap;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContainerScrapApproveEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $containerScrap;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContainerScrap $containerScrap)
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
        return $this->subject('Container Scrap Approve Email')->markdown('mail.scrap-approve-email')->with('containerScrap', $this->containerScrap);
    }
}
