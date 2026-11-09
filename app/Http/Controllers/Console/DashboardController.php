<?php

namespace App\Http\Controllers\Console;

use App\Enums\TransactionStatusEnum;
use App\Mail\WhatsappServiceEmail;
use App\Models\User;
use App\Models\Product;
use App\Models\Config;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Services\WhatspieService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index(WhatspieService $whatspieService)
    {

        $body = $whatspieService->getStatus();
        $responseData = json_decode($body, true);
        // dd($responseData);

        $config = Config::where('name', 'whatsapp-notif')->first();
        $alertMessage = '';

        if ((!$responseData || $responseData['state'] != 'CONNECTED') && $config->status) {
            $alertMessage = "Whatsapp Notification Service: NOT CONNECTED";
            DB::beginTransaction();
            $config->status = '0';
            $config->save();
            Mail::to('it@baracoal.com')->send(new WhatsappServiceEmail());
            DB::commit();
        }
        return view('console.index')->with('alertMessage', $alertMessage);
    }

    public function downloadUserManual()
    {
        // file in public.assets.user-manual/ctc-baracoal-user-manual.pdf
        $file = public_path('assets/user-manual/ctc-baracoal-user-manual.pdf');
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($file, 'ctc_app_user_manual.pdf', $headers);
    }
}
