<?php

namespace App\Mail;

use App\Models\ContainerRepair;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProgressApprovedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $containerRepair;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContainerRepair $containerRepair)
    {
        $this->containerRepair = $containerRepair;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.container-repair-approved-email')->with('containerRepair', $this->containerRepair);
    }
}
