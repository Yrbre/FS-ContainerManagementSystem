<?php

namespace App\Http\Controllers\Console\Master;

use App\Http\Controllers\Controller;
use App\Services\WhatspieService;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ConfigCreateRequest;
use App\DataTables\Console\ConfigDataTable;
use App\Http\Requests\ConfigUpdateRequest;
use App\Repositories\Console\ConfigRepository;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class ConfigController extends Controller
{
    public function index(ConfigDataTable $dataTable)
    {
        $content_title = 'Config';
        return $dataTable->render('console.master.config.index');
    }

    public function create()
    {
        $content_title = 'Config';
        return view('console.master.config.create', compact('content_title'));
    }

    public function store(ConfigCreateRequest $request, ConfigRepository $repository)
    {

        try {

            $config = $request->validated();
            return $repository->store($config);

        } catch (\Exception $e) {
            return redirect()->route('console.config.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }

    public function show(Config $config)
    {
        return view('console.master.config.show', compact('config'));
    }

    public function edit(Config $config)
    {
        $content_title = 'Config';
        return view('console.master.config.edit', compact('config', 'content_title'));

    }

    public function update(ConfigUpdateRequest $request, Config $config, ConfigRepository $repository)
    {

        try {

            $data = $request->validated();
            return $repository->update($config->id, $data);

        } catch (\Exception $e) {
            return redirect()->route('console.config.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }

    public function destroy(Config $config, ConfigRepository $repository)
    {

        try {
            return $repository->destroy($config->id);
        } catch (\Exception $e) {
            return redirect()->route('console.config.index')->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }

    }

    public function start_session(WhatspieService $whatspieService)
    {
        try {
            $body = $whatspieService->startSession();
            $responseData = json_decode($body, true);

            if ($responseData['success']) {
                return back()->with('success', $responseData['message'] . ' Please open and scan QRcode to connect device.');
            } else {
                return back()->with('error', 'Please scan QRcode. ' .$responseData['message']);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
    }

    public function terminate_session(WhatspieService $whatspieService)
    {
        try {
            $body = $whatspieService->terminateSession();
            $responseData = json_decode($body, true);

            if ($responseData['success']) {
                return back()->with('success', $responseData['message']);
            } else {
                return back()->with('error', $responseData['message']);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Server Error: Terjadi kesalahan pada server.');
        }
    }


}
