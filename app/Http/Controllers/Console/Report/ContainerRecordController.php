<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContainerRecordController extends Controller
{
    public function index() {
        return view('console.report.container-record'); 
    }
}
