<?php

namespace App\Repositories\Console;

use App\Models\ContainerDelegationFromVendorDetail;
use Exception;
use App\Models\Admin;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Enums\JobTypeEnum;
use Predis\Command\Redis\SSCAN;
use Illuminate\Support\Facades\DB;
use App\Models\ContainerDelegation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DelegationToVendorEmail;
use Illuminate\Support\Facades\Storage;
use App\Models\ContainerDelegationDetail;
use App\Mail\DelegationToVendorRejectEmail;
use App\Mail\DelegationToVendorApproveEmail;
use App\Models\ContainerDelegationSubDetail;

class ContainerDelegationToVendorRepository
{
    public function store(array $data)
    {
        $data['created_by'] = Auth::id();

        return ContainerDelegation::create($data);
    }

    public function posted(ContainerDelegation $containerDelegation)
    {
        // Harus DRAFT
        if ($containerDelegation->status != StatusEnum::DRAFT)
            throw new Exception("Status transaksi harus DRAFT");

        $details = [];
        $details = $containerDelegation->details()->get();

        if ($details->count() < 1 || $details == [])
            throw new Exception("Tidak bisa melakukan POST karena Tidak Ada Detail");

        // Container Activity Detail
        DB::beginTransaction();

        $containerDelegation->status = StatusEnum::POSTED;
        $containerDelegation->last_updated_by = Auth::id();
        $containerDelegation->post_date = now();
        $containerDelegation->post_by = Auth::id();
        $containerDelegation->save();

        if (!$containerDelegation)
            throw new Exception("Gagal melakukan POST BAST ke Vendor");

        if ($details) {

            foreach ($details as $detail) {

                if ($containerDelegation->job_type == 'Maintenance') {
                    $detail->container->last_maintenance_date = $containerDelegation->action_date;
                    $detail->container->last_maintenance_vendor_id = $containerDelegation->vendor_id;
                } elseif ($containerDelegation->job_type == 'Upgrade & Repair') {
                    $detail->container->last_upgrade_date = $containerDelegation->action_date;
                    $detail->container->last_upgrade_vendor_id = $containerDelegation->vendor_id;
                }

                $detail->container->save();

                $detail->update([
                    'carriage_number' => $detail->container->down_carriage_no
                ]);
            }
        }

        // Send Email Notification to CTC Supervisor
        Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($containerDelegation) {
            Mail::to($admin)->send(new DelegationToVendorEmail($containerDelegation));
        });

        DB::commit();
    }

    public function update(ContainerDelegation $containerDelegation, array $data)
    {
        return $containerDelegation->update($data);
    }

    public function destroy(ContainerDelegation $containerDelegation)
    {
        $details = $containerDelegation->details()->get();

        if ($details) {
            foreach ($details as $detail) {
                $subDetails = $detail->subDetails()->get();

                if ($subDetails) {
                    foreach ($subDetails as $sub) {
                        foreach ($sub->images as $subImg) {
                            if ($subImg) {
                                Storage::delete($subImg);
                            }
                        }

                        $sub->delete();
                    }
                }

                foreach ($detail->images as $img) {
                    if ($img) {
                        Storage::delete($img);
                    }
                }

                // Hapus detail dari vendor yang terkait dengan detail ini
                ContainerDelegationFromVendorDetail::where('container_delegation_detail_id', $detail->id)->delete();

                $detail->delete();
            }
        }

        $containerDelegation->delete();
    }

    public function approve(ContainerDelegation $containerDelegation)
    {
        $details = $containerDelegation->details()->get();

        if ($containerDelegation->job_type == JobTypeEnum::MAINTENANCE) {
            $subs = false;
            $rootCause = null;

            if ($details->count() > 0) {
                foreach ($details as $detail) {
                    $subs = $detail->subDetails()->get();

                    if ($subs->count() > 0) {
                        foreach ($subs as $sub) {
                            $rootCause = $sub->root_cause;
                        }
                    } else {
                        throw new Exception("Error: Gagal melakukan Approve BAST ke Vendor. Terdapat CT yang tidak mempunyai Sub Detail Pekerjaan");
                    }
                }
            }

            // Not Have Sub Detail
            if ($subs == false)
                throw new Exception("Error: Gagal melakukan Approve BAST ke Vendor. Karena BAST ini tidak mempunyai Sub Detail Pekerjaan");

            // Root Cause Null
            if ($rootCause == null)
                throw new Exception("Error: Gagal melakukan Approve BAST ke Vendor. Silahkan isi Root Cause terlebih dahulu di Sub Detail Pekerjaan");
        }

        $admin = Admin::where('id', Auth::id())->first();

        if ($admin->role == 'Administrator' || $admin->role == 'Supervisor' && $containerDelegation->status == StatusEnum::POSTED) {
            $containerDelegation->status = 'APPROVE1';
            $containerDelegation->approve_date = now();
            $containerDelegation->approve_by = Auth::id();
            $containerDelegation->last_updated_by = Auth::id();
            $containerDelegation->reason_approve = request()->input('reason_approve');
            $containerDelegation->save();

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::MANAGER)->get()->each(function (Admin $admin) use ($containerDelegation) {
                Mail::to($admin)->send(new DelegationToVendorApproveEmail($containerDelegation));
            });
        } elseif ($admin->role == 'Administrator' || $admin->role == 'Manager' && $containerDelegation->status == 'APPROVE1') {
            $containerDelegation->status = 'APPROVE2';
            $containerDelegation->approve2_date = now();
            $containerDelegation->approve2_by = Auth::id();
            $containerDelegation->last_updated_by = Auth::id();
            $containerDelegation->reason_approve = request()->input('reason_approve');
            $containerDelegation->save();

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::FINANCE)->get()->each(function (Admin $admin) use ($containerDelegation) {
                Mail::to($admin)->send(new DelegationToVendorApproveEmail($containerDelegation));
            });
        } elseif ($admin->role == 'Administrator' || $admin->role == 'Finance' && $containerDelegation->status == 'APPROVE2') {
            $containerDelegation->status = 'APPROVE3';
            $containerDelegation->approve3_date = now();
            $containerDelegation->approve3_by = Auth::id();
            $containerDelegation->last_updated_by = Auth::id();
            $containerDelegation->reason_approve = request()->input('reason_approve');
            $containerDelegation->save();

            // Send Email Notification to CTC Supervisor
            Admin::whereIn('role', [RoleEnum::SUPERVISOR, RoleEnum::MANAGER])->get()->each(function (Admin $admin) use ($containerDelegation) {
                Mail::to($admin)->send(new DelegationToVendorApproveEmail($containerDelegation));
            });
        }
    }

    public function reject(ContainerDelegation $containerDelegation)
    {
        $admin = Admin::where('id', Auth::id())->first();

        $containerDelegation->approve_date = null;
        $containerDelegation->approve_by = null;

        if ($admin->role == 'Administrator' || $admin->role == 'Supervisor' && $containerDelegation->status == 'POSTED') {
            $containerDelegation->status = 'DRAFT';
            $containerDelegation->last_updated_by = Auth::id();
            $containerDelegation->reason_reject = request()->input('reason_reject');
            $containerDelegation->save();



            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::CHECKER)->get()->each(function (Admin $admin) use ($containerDelegation) {
                Mail::to($admin)->send(new DelegationToVendorRejectEmail($containerDelegation));
            });
        } elseif ($admin->role == 'Administrator' || $admin->role == 'Manager' && $containerDelegation->status == 'APPROVE1') {
            $containerDelegation->status = 'POSTED';
            $containerDelegation->last_updated_by = Auth::id();
            $containerDelegation->reason_reject = request()->input('reason_reject');
            $containerDelegation->save();

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($containerDelegation) {
                Mail::to($admin)->send(new DelegationToVendorRejectEmail($containerDelegation));
            });
        } elseif ($admin->role == 'Administrator' || $admin->role == 'Finance' && $containerDelegation->status == 'APPROVE2') {
            $containerDelegation->status = 'POSTED';
            $containerDelegation->last_updated_by = Auth::id();
            $containerDelegation->reason_reject = request()->input('reason_reject');
            $containerDelegation->save();

            // Send Email Notification to CTC Supervisor
            Admin::whereIn('role', [RoleEnum::SUPERVISOR, RoleEnum::MANAGER])->get()->each(function (Admin $admin) use ($containerDelegation) {
                Mail::to($admin)->send(new DelegationToVendorRejectEmail($containerDelegation));
            });
        }

        $containerDelegation->details()->get()->each(function ($detail) use ($containerDelegation) {
            if ($containerDelegation->job_type == 'Maintenance') {
                $detail->container->update([
                    'last_maintenance_date' => NULL,
                    'last_maintenance_vendor_id' => NULL,
                ]);
            } elseif ($containerDelegation->job_type == 'Upgrade & Repair') {
                $detail->container->update([
                    'last_upgrade_date' => NULL,
                    'last_upgrade_vendor_id' => NULL,
                ]);
            }
        });
    }

    public function unapprove(ContainerDelegation $containerDelegation)
    {
        $admin = Admin::where('id', Auth::id())->first();
        $containerCode = $containerDelegation->details()->pluck('container_code');
        $containers = ContainerDelegationFromVendorDetail::whereIn('container_code', $containerCode)
            ->where('created_at', '>', $containerDelegation->action_date)
            ->get();

        if ($containers->count() > 0) {
            throw new Exception("Error: Detail BAST 1 sudah diproses di transaksi lain.");
        }

        $containerDelegation->approve_date = null;
        $containerDelegation->approve_by = null;

        $containerDelegation->status = 'DRAFT';
        $containerDelegation->last_updated_by = Auth::id();
        $containerDelegation->reason_reject = request()->input('reason_reject');
        $containerDelegation->save();

        // Send Email Notification to CTC Supervisor
        Admin::where('role', RoleEnum::CHECKER)->get()->each(function (Admin $admin) use ($containerDelegation) {
            Mail::to($admin)->send(new DelegationToVendorRejectEmail($containerDelegation));
        });

        // Send Email Notification to CTC Manager
        Admin::whereIn('role', [RoleEnum::MANAGER])->get()->each(function (Admin $admin) use ($containerDelegation) {
            Mail::to($admin)->send(new DelegationToVendorRejectEmail($containerDelegation));
        });

        $containerDelegation->details()->get()->each(function ($detail) use ($containerDelegation) {
            if ($containerDelegation->job_type == 'Maintenance') {
                $detail->container->update([
                    'last_maintenance_date' => NULL,
                    'last_maintenance_vendor_id' => NULL,
                ]);
            } elseif ($containerDelegation->job_type == 'Upgrade & Repair') {
                $detail->container->update([
                    'last_upgrade_date' => NULL,
                    'last_upgrade_vendor_id' => NULL,
                ]);
            }
        });
    }

    public function subDetailDestroy($subDetailId)
    {
        $subDetail = ContainerDelegationSubDetail::where('id', $subDetailId)->first();

        if ($subDetail) {
            foreach ($subDetail->images as $image) {
                Storage::delete($image);
            }
        }

        $subDetail->delete();
    }

    public function getDataTableQuery()
    {
        $query = ContainerDelegation::withoutTrashed()->with('location', 'vendor', 'createdByUser')->select('container_delegations.*');

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

    public function duplicateSubDetail($subDetailId)
    {
        $subDetail = ContainerDelegationSubDetail::where('id', $subDetailId)->first();

        $newSub = new ContainerDelegationSubDetail;
        $newSub->ct_delegation_detail_id = $subDetail->ct_delegation_detail_id;
        $newSub->qty = $subDetail->qty;
        $newSub->unit = $subDetail->unit;
        $newSub->job_type = $subDetail->job_type;
        $newSub->root_cause = $subDetail->root_cause;
        $newSub->unit_price = $subDetail->unit_price;
        $newSub->description = $subDetail->description;
        $newSub->material_size = $subDetail->material_size;
        $newSub->damage_description = $subDetail->damage_description;
        $newSub->price_estimation = (int) $subDetail->qty * (int) $subDetail->unit_price;
        $newSub->contract_detail_id = $subDetail->contract_detail_id;
        $newSub->images = $subDetail->images;
        $newSub->save();
    }

    public function detailDelete($delegationDetailId)
    {
        $detail = ContainerDelegationDetail::where('id', $delegationDetailId)->first();

        foreach ($detail->images as $image) {
            Storage::delete($image);
        }

        $detail->delete();
    }
}