<?php

namespace App\Mail;

use App\Models\Inspection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InspectionNotificationEmail extends Mailable implements ShouldQueue
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
        return $this->markdown('mail.inspection-notification-email')->with('inspection', $this->inspection);
    }
}
