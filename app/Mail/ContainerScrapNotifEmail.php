<?php

namespace App\Mail;

use App\Models\ContainerScrap;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContainerScrapNotifEmail extends Mailable implements ShouldQueue
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
        return $this->markdown('mail.scrap-notif-email')->with('containerScrap', $this->containerScrap);
    }
}
