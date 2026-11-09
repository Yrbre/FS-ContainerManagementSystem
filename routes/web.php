<?php

use App\Mail\InspectionNotificationEmail;
use App\Models\Contract;
use App\Models\Inspection;
use App\Repositories\Console\ContractRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect()->to('/console/login');
});

Route::get('/test', function(ContractRepository $contractRepository){
    // dd($contractRepository->calculateWarrantyFromDate(Contract::find(1), now()->addDays(2)));
});
