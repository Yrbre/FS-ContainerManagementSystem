<?php

namespace App\Repositories\Console;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Mail\InspectionApprovedEmail;
use App\Mail\InspectionNotificationEmail;
use App\Mail\InspectionRejectedEmail;
use App\Models\Admin;
use App\Models\Config;
use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Services\WhatspieService;
use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class InspectionRepository
{
    protected $whatspieService;

    public function __construct(WhatspieService $whatspieService)
    {
        $this->whatspieService = $whatspieService;
    }

    public function store(array $data)
    {
        $data['created_by'] = Auth::id();

        return Inspection::create(
            $data
        );
    }

    public function posted(Inspection $inspection)
    {
        // Harus DRAFT
        if ($inspection->status != StatusEnum::DRAFT)
            throw new Exception("Status transaksi harus DRAFT");

        if ($inspection->details()->count() == 0) {
            throw new Exception("Mohon untuk menambahkan detail kontainer terlebih dahulu");
        }

        DB::beginTransaction();

        // Update status to Posted
        $inspection->status = StatusEnum::POSTED;
        $inspection->post_date = now();
        $inspection->post_by = auth()->user()->id;
        $inspection->last_updated_by = auth()->user()->id;
        $inspection->save();

        // Update semua kontainer ke TSO
        $inspection->details->each(function (InspectionDetail $inspectionDetail) {
            if ($inspectionDetail->container->status->code == 'SO' || $inspectionDetail->container->status->code == 'SOI') {
                $inspectionDetail->container->updateStatusByCode('TSOI');
            } else {
                $inspectionDetail->container->updateStatusByCode('TSO');
            }
        });
        // Kirim notifikasi
        // 1. via email ke CTC Supervisor
        Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($inspection) {
            Mail::to($admin)->send(new InspectionNotificationEmail($inspection));
        });

        // 2. via Whatsapp ke WA GROUP
        $message = "*LAPORAN HASIL INSPEKSI CT*\n";
        $message .= "No. $inspection->code\n";
        $message .= "Lokasi. {$inspection->location->code}\n";
        $message .= "Tgl. {$inspection->action_date->format('d-m-Y H:i:s')}\n";
        $message .= "No. KA. {$inspection->ka_no}\n\n";
        $grouped = $inspection->details->groupBy('container_code');
        foreach ($grouped as $key => $g) {
            $message .= "*CT $key*\n";
            foreach ($g as $key2 => $d) {
                $message .= "{$d->damage_description}\n";
                foreach ($d->images as $img) {
                    $message .= Storage::url($img) . "\n";
                }
                $message .= "\n";
            }
            $message .= "-----------------------------------------------------\n";
        }

        // $this->whatspieService->sendMessageToGroup($message);
        // DB::commit();

        // Retrieve the config by name
        $config = Config::where('name', 'whatsapp-notif')->first();

        // Check if the config exists
        if ($config) {
            // Return the status
            if ($config->status) {
                $this->whatspieService->sendMessageToGroup($message);
                DB::commit();
            } else {
                DB::commit();
            }
        } else {
            DB::commit();
        }
    }

    public function update(Inspection $inspection, array $data)
    {
        return $inspection->update($data);
    }

    public function approve(Inspection $inspection)
    {

        if ($inspection->fixing_job_type == null) {
            throw new Exception("Jenis perbaikan harus di isi.");
        }

        if (
            $inspection->details()->each(function (InspectionDetail $inspectionDetail) {
                if ($inspectionDetail->root_cause == null) {
                    throw new Exception($inspectionDetail->container_code . " - Root Cause harus diisi");
                }
            })
        )
            ;

        DB::beginTransaction();

        $inspection->details()->each(function (InspectionDetail $inspectionDetail) use ($inspection) {
            // update container last_type_maintenance
            $inspectionDetail->container->last_type_maintenance = $inspection->fixing_job_type;
            $inspectionDetail->container->save();

        });

        $inspection->status = StatusEnum::APPROVE;
        $inspection->approve_date = now();
        $inspection->approve_by = auth()->user()->id;
        $inspection->last_updated_by = auth()->user()->id;
        $inspection->save();


        // send email
        $checker = $inspection->createdByUser->email;
        Mail::to($checker)->send(new InspectionApprovedEmail($inspection));

        DB::commit();
    }

    public function reject(Inspection $inspection)
    {

        $inspection->last_updated_by = auth()->user()->id;
        $inspection->status = StatusEnum::DRAFT;
        $inspection->save();

        // send email
        $checker = $inspection->createdByUser->email;
        Mail::to($checker)->send(new InspectionRejectedEmail($inspection));
    }

    public function detailDestroy(InspectionDetail $inspectionDetail)
    {
        return $inspectionDetail->delete();
    }

    public function getDataTableQuery()
    {
        $query = Inspection::with(['location', 'createdByUser'])->select('inspections.*');

        if (Auth::check()) {

            // if (Auth::user()->hasOnlyRole(RoleEnum::SUPERVISOR)) {
            //     $query->where('status', StatusEnum::POSTED);
            // }
        }

        return $query;
    }

    public function set_group_notif($id, $name, $param_message)
    {

        $url = 'http://172.16.10.113:8000/send-group-message';
        $data = ['name' => $name, 'message' => $param_message];
        $response = Http::post($url, $data);

        if ($response->failed()) {
            throw new Exception("Notif failed.");
        } else {
            return true;
        }
    }
}
