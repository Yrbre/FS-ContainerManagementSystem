<?php

namespace App\Events;

use App\Models\InspectionDetail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InspectionDetailCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $inspectionDetail;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(InspectionDetail $inspectionDetail)
    {
        $this->inspectionDetail = $inspectionDetail;
    }
}
