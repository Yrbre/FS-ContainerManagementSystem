<?php

namespace App\Http\Controllers\Console\Report;

use App\Models\Vendor;
use App\Models\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ContainerDashboardController extends Controller
{
  
    public function index() {
         return view('console.report.container-dashboard'); 
    }
}
