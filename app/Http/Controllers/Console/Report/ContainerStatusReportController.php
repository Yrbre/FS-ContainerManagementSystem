<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContainerStatusReportController extends Controller
{
    public function index() {
        return view('console.report.container-status-report'); 
    }
}
