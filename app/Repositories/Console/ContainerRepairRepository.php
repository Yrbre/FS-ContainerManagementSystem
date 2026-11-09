<?php

namespace App\Repositories\Console;

use Exception;
use App\Models\Admin;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Container;
use App\Models\Inspection;
use App\Models\ContainerRepair;
use App\Models\InspectionDetail;
use App\Services\WhatspieService;
use Illuminate\Support\Facades\DB;
use App\Mail\ProgressApprovedEmail;
use App\Mail\ProgressRejectedEmail;
use App\Models\ContainerDelegation;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InspectionApprovedEmail;
use App\Mail\InspectionRejectedEmail;
use App\Mail\ProgressNotificationEmail;
use Illuminate\Support\Facades\Storage;
use App\Mail\InspectionNotificationEmail;
use App\Models\ContainerRepairDetail;

class ContainerRepairRepository
{

    public function store(array $data)
    {
        $data['created_by'] = Auth::id();

        DB::beginTransaction();

        $containerRepair =  ContainerRepair::create(
            $data
        );

        $lastId = $containerRepair->id;

        // Logic Step
        // 1. Cek ke BAST1, CT mana yang masih belum selesai
        $ctDelegation = ContainerDelegation::where('vendor_id', $data['vendor_id'])
            ->where('location_id', $data['location_id'])
            ->where('status', '!=', StatusEnum::DRAFT)
            ->orderBy('created_at', 'desc')
            ->get();
            
        if (count($ctDelegation) <= 0) throw new Exception("Error: Belum ada data BAST untuk lokasi dan vendor yang dipilih.");

        foreach ($ctDelegation as $key => $ctDelegationDetail) {
            
            foreach ($ctDelegationDetail->details()->where('is_done', false)->get() as $key => $ctDetail) {
                
                // Kalo proses BAST sudah selesai, skil
                if ($ctDetail->is_done) continue;

                $progress = 0;
                // TODO : Check apakah container ini mempunyai progress terakhir
                if ($lastRepair = ContainerRepairDetail::where('container_delegation_detail_id', $ctDetail->id)->first()) {
                    $progress = $lastRepair->progress;
                }
                
                // Insert ke details progress
                $containerRepair->details()->create([
                    'container_code' => $ctDetail->container_code,
                    'container_repair_id' => $lastId,
                    'progress' => $progress,
                    'container_delegation_detail_id' => $ctDetail->id,
                    'created_by' => Auth::id(),
                ]);
            }
        }

        DB::commit();

        return $containerRepair;
    }

    public function posted(ContainerRepair $containerRepair)
    {
        // Harus DRAFT
        if ($containerRepair->status != StatusEnum::DRAFT) throw new Exception("Status transaksi harus DRAFT");

        DB::beginTransaction();

        // Update status to Posted
        $containerRepair->status = StatusEnum::POSTED;
        $containerRepair->post_date = now();
        $containerRepair->post_by = auth()->user()->id;
        $containerRepair->last_updated_by = auth()->user()->id;
        $containerRepair->save();


        // Kirim notifikasi
        // 1. via email ke CTC Supervisor
        Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($containerRepair) {
            Mail::to($admin)->send(new ProgressNotificationEmail($containerRepair));
        });

        DB::commit();
    }

    public function update(ContainerRepair $containerRepair, array $data)
    {
        return $containerRepair->update($data);
    }

    public function destroy(ContainerRepair $repair)
    {
        $repair->delete();
        // detail must be delete to 
        return $repair->details()->delete();
    }

    public function reject(ContainerRepair $containerRepair)
    {

        $containerRepair->last_updated_by = auth()->user()->id;
        $containerRepair->status = StatusEnum::DRAFT;
        $containerRepair->save();

        // send email
        $checker = $containerRepair->createdByUser>email;
        Mail::to($checker)->send(new ProgressRejectedEmail($containerRepair));
    }


    public function approve(ContainerRepair $containerRepair)
    {


        $progressBefore = ContainerRepair::where('created_at', '<', $containerRepair->created_at)
            ->where('location_id', $containerRepair->location_id)
            ->where('vendor_id', $containerRepair->vendor_id)
            ->whereIn('status', [StatusEnum::DRAFT, StatusEnum::POSTED])
            ->get();

        if ($progressBefore->count() > 0) {
            throw new Exception("Terdapat Laporan progress Vendor dan Lokasi sama yang belum di setujui");
        }

        $containerRepair->status = StatusEnum::APPROVE;
        $containerRepair->approve_date = now();
        $containerRepair->approve_by = auth()->user()->id;
        $containerRepair->last_updated_by = auth()->user()->id;
        $containerRepair->save();

        // send email
        $checker = $containerRepair->createdByUser->email;
        Mail::to($checker)->send(new ProgressApprovedEmail($containerRepair));
    }

    public function getDataTableQuery()
    {
        $query = ContainerRepair::with(['location', 'vendor', 'createdByUser'])
        ->select('container_repairs.*');

        if (Auth::check()) {

            // if (Auth::user()->hasOnlyRole(RoleEnum::SUPERVISOR)) {
            //     $query->where('status', StatusEnum::POSTED);
            // }
        }

        return $query;
    }
}
