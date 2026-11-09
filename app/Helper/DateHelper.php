<?php
namespace App\Helper;

use Carbon\Carbon;

class DateHelper
{
    public static function format($date)
    {
        if (!$date) return null;
        return Carbon::parse($date)->format('d-m-Y');
    }
}