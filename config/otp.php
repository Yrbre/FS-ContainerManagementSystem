<?php

return [
    /**
     * OTP Expired in minutes
     */
    'ttl' => 10,

    'driver_sms' => env('OTP_DRIVER_SMS', 'log')
];