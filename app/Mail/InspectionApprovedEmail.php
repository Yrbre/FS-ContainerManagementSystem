<?php

namespace App\Mail;

use App\Models\Inspection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InspectionApprovedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $inspection;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inspection $inspection)
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
        return $this->markdown('mail.inspection-approved-email')->with('inspection', $this->inspection);
    }
}
