<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspectionRejectedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    protected $inspection;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inspection)
    {
        $this->inspection = $inspection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.inspection-rejected-email')->with('inspection', $this->inspection);
    }
}
