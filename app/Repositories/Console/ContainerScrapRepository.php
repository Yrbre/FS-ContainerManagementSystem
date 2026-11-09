<?php

namespace App\Repositories\Console;

use App\Mail\ContainerScrapApproveEmail;
use App\Mail\ContainerScrapNotifEmail;
use App\Mail\ContainerScrapRejectEmail;
use App\Models\ContainerScrapDetail;
use Exception;
use App\Models\Admin;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Enums\JobTypeEnum;
use Predis\Command\Redis\SSCAN;
use Illuminate\Support\Facades\DB;
use App\Models\ContainerScrap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DelegationToVendorEmail;
use Illuminate\Support\Facades\Storage;
use App\Models\ContainerDelegationDetail;
use App\Mail\DelegationToVendorRejectEmail;
use App\Mail\DelegationToVendorApproveEmail;
use App\Models\ContainerDelegationSubDetail;

class ContainerScrapRepository
{
    public function store($data)
    {
        $data['created_by'] = Auth::id();
        // if exist upload documents
        $documents = $data['documents'] ?? [];
        unset($data['documents']);
        $docs = [];
        foreach ($documents as $doc) {
            array_push($docs, $doc->storePublicly('documents/scrap/'));
        }
        $data['documents'] = $docs;
        return ContainerScrap::create($data);
    }

    public function posted(ContainerScrap $containerScrap)
    {
        // Harus DRAFT
        if ($containerScrap->status != StatusEnum::DRAFT)
            throw new Exception("Status transaksi harus DRAFT");

        $details = [];
        $details = $containerScrap->details()->get();

        if ($details->count() < 1 || $details == [])
            throw new Exception("Tidak bisa melakukan POST karena Tidak Ada Detail Scrap");

        // Container Activity Detail
        DB::beginTransaction();

        $containerScrap->status = StatusEnum::POSTED;
        $containerScrap->last_updated_by = Auth::id();
        $containerScrap->post_date = now();
        $containerScrap->post_by = Auth::id();
        $containerScrap->save();

        if (!$containerScrap)
            throw new Exception("Gagal melakukan POST BAST ke Vendor");

        // Send Email Notification to CTC Manager
        try {
            Admin::where('role', RoleEnum::MANAGER)->get()->each(function (Admin $admin) use ($containerScrap) {
                Mail::to($admin)->send(new ContainerScrapNotifEmail($containerScrap));
            });
        } catch (\Exception $e) {
            Log::error($e);
            dd($e->getMessage());
            session()->flash('error', $e->getMessage());
        }

        DB::commit();
    }

    public function update(ContainerScrap $containerScrap, $data)
    {
        if (isset($data['documents'])) {
            $documents = $data['documents'] ?? [];
            unset($data['documents']);
            $docs = [];
            foreach ($documents as $doc) {
                array_push($docs, $doc->storePublicly('documents/scrap/'));
            }
            $data['documents'] = $docs;
        } else {
            $data['documents'] = $containerScrap->documents;
        }
        return $containerScrap->update($data);
    }

    public function destroy(ContainerScrap $containerScrap)
    {
        $details = $containerScrap->details()->get();

        if ($details) {
            foreach ($details as $detail) {

                foreach ($detail->images as $img) {
                    if ($img) {
                        Storage::delete($img);
                    }
                }

                $detail->delete();
            }
        }
        $containerScrap->delete();
    }

    public function approve(ContainerScrap $containerScrap)
    {
        $admin = Admin::where('id', Auth::id())->first();

        if ($admin->role == 'Administrator' || $admin->role == 'Manager' && $containerScrap->status == StatusEnum::POSTED) {
            $containerScrap->status = 'APPROVE1';
            $containerScrap->approve_date = now();
            $containerScrap->approved_by = Auth::id();
            $containerScrap->last_updated_by = Auth::id();
            $containerScrap->reason_approve = request()->input('reason_approve');
            $containerScrap->save();

            //Change container status to S (Scrap)
            $containerScrap->details->each(function (ContainerScrapDetail $containerScrapDetail) {
                $containerScrapDetail->container->updateStatusByCode('S');
            });

            // Send Email Notification to CTC Supervisor
            try {
                Admin::where('role', RoleEnum::MANAGER)->get()->each(function (Admin $admin) use ($containerScrap) {
                    Mail::to($admin)->send(new ContainerScrapApproveEmail($containerScrap));
                });
            } catch (\Exception $e) {
                Log::error($e);
                dd($e->getMessage());
                session()->flash('error', $e->getMessage());
            }

        } elseif ($admin->role == 'Administrator' || $admin->role == 'Finance' && $containerScrap->status == 'APPROVE1') {
            $containerScrap->status = 'APPROVE2';
            $containerScrap->approve2_date = now();
            $containerScrap->approve2_by = Auth::id();
            $containerScrap->last_updated_by = Auth::id();
            $containerScrap->reason_approve = request()->input('reason_approve');
            $containerScrap->save();

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::FINANCE)->get()->each(function (Admin $admin) use ($containerScrap) {
                Mail::to($admin)->send(new ContainerScrapApproveEmail($containerScrap));
            });
        }
    }

    public function reject(ContainerScrap $containerScrap)
    {
        $admin = Admin::where('id', Auth::id())->first();

        $containerScrap->approve_date = null;
        $containerScrap->approved_by = null;

        if ($admin->role == 'Administrator' || $admin->role == 'Manager' && $containerScrap->status == 'POSTED') {
            $containerScrap->status = 'DRAFT';
            $containerScrap->last_updated_by = Auth::id();
            $containerScrap->reason_reject = request()->input('reason_reject');
            $containerScrap->save();

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($containerScrap) {
                Mail::to($admin)->send(new ContainerScrapRejectEmail($containerScrap));
            });
        } elseif ($admin->role == 'Administrator' || $admin->role == 'Finance' && $containerScrap->status == 'APPROVE1') {
            $containerScrap->status = 'POSTED';
            $containerScrap->last_updated_by = Auth::id();
            $containerScrap->reason_reject = request()->input('reason_reject');
            $containerScrap->save();

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($containerScrap) {
                Mail::to($admin)->send(new ContainerScrapRejectEmail($containerScrap));
            });
        }
    }

    public function getDataTableQuery()
    {
        $query = ContainerScrap::withoutTrashed()->with('location', 'vendor', 'createdByUser')->select('container_scraps.*');

        if (Auth::check()) {
            // if (Auth::user()->hasOnlyRole(RoleEnum::SUPERVISOR)) {
            //     $query->where('status', StatusEnum::POSTED);
            // } elseif (Auth::user()->hasOnlyRole(RoleEnum::MANAGER)) {
            //     $query->where('status', StatusEnum::APPROVE1);
            // } elseif (Auth::user()->hasOnlyRole(RoleEnum::FINANCE)) {
            //     $query->where('status', StatusEnum::APPROVE2);
            // }
        }

        return $query;
    }

    public function detailDelete($delegationDetailId)
    {
        $detail = ContainerDelegationDetail::where('id', $delegationDetailId)->first();

        foreach ($detail->images as $image) {
            Storage::delete($image);
        }

        $detail->delete();
    }

    public function detailDestroy(ContainerScrapDetail $containerScrapDetail)
    {
        DB::beginTransaction();


        if (!empty($containerScrapDetail->images)) {
            foreach ($containerScrapDetail->images as $img) {
                Storage::delete($img);
            }
        }
        $containerScrapDetail->delete();

        DB::commit();
    }
}