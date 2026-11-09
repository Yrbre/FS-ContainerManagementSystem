<?php

namespace App\Repositories\Console;

use App\Models\Record;
use Exception;
use App\Models\Admin;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Container;
use App\Enums\JobTypeEnum;
use App\Models\ContainerRepair;
use Predis\Command\Redis\SSCAN;
use Illuminate\Support\Facades\DB;
use App\Models\ContainerDelegation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DelegationToVendorEmail;
use App\Models\ContainerRepairDetail;
use App\Mail\DelegationFromVendorEmail;
use Illuminate\Support\Facades\Storage;
use App\Models\ContainerDelegationDetail;
use App\Mail\DelegationToVendorRejectEmail;
use App\Mail\DelegationToVendorApproveEmail;
use App\Models\ContainerDelegationSubDetail;
use App\Mail\DelegationFromVendorRejectEmail;
use App\Models\ContainerDelegationFromVendor;
use App\Repositories\Console\ContractRepository;
use App\Models\ContainerDelegationFromVendorDetail;
use App\Models\ContainerDelegationFromVendorSubDetail;

class ContainerDelegationFromVendorRepository
{

    protected ContractRepository $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function store(array $data)
    {
        $data['created_by'] = Auth::id();

        return ContainerDelegationFromVendor::create($data);
    }

    public function posted(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        // Harus DRAFT
        if ($containerDelegationFromVendor->status != StatusEnum::DRAFT)
            throw new Exception("Status transaksi harus DRAFT");

        $details = $containerDelegationFromVendor->details;

        if ($details->count() < 1 || $details == [])
            throw new Exception("Tidak bisa melakukan POST karena Tidak Ada Detail");

        // Container Activity Detail
        DB::beginTransaction();

        $this->updateProgress($containerDelegationFromVendor);

        $containerDelegationFromVendor->status = StatusEnum::POSTED;
        $containerDelegationFromVendor->last_updated_by = Auth::id();
        $containerDelegationFromVendor->post_date = now();
        $containerDelegationFromVendor->post_by = Auth::id();
        $containerDelegationFromVendor->save();

        // foreach ($details as $detail) {
        //     // ContainerDelegationDetail::where('id', $detail->container_delegation_detail_id)->update([
        //     //     'is_done' => true
        //     // ]);
        // }

        if (!$containerDelegationFromVendor)
            throw new Exception('Gagal melakukan POST BAST dari Vendor');

        // Send Email Notification to CTC Supervisor
        Admin::where('role', RoleEnum::SUPERVISOR)->get()->each(function (Admin $admin) use ($containerDelegationFromVendor) {
            Mail::to($admin)->send(new DelegationFromVendorEmail($containerDelegationFromVendor));
        });

        DB::commit();
    }

    public function update(ContainerDelegationFromVendor $containerDelegationFromVendor, array $data)
    {
        return $containerDelegationFromVendor->update($data);
    }

    public function destroy(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        $details = $containerDelegationFromVendor->details()->get();

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

        $containerDelegationFromVendor->delete();
    }

    public function approve(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        DB::beginTransaction();
        $admin = Admin::where('id', Auth::id())->first();

        //Check transaksi dan status CT
        $containerCode = $containerDelegationFromVendor->details()->pluck('container_code');


        if ($admin->hasRole('Supervisor') && $containerDelegationFromVendor->status == StatusEnum::POSTED) {
            $containerDelegationFromVendor->status = 'APPROVE';
            $containerDelegationFromVendor->approve_date = now();
            $containerDelegationFromVendor->approved_by = Auth::id();
            $containerDelegationFromVendor->last_updated_by = Auth::id();
            $containerDelegationFromVendor->save();

            $containerCode = $containerDelegationFromVendor->details()->pluck('container_code');

            $containers = Container::whereIn('code', $containerCode)->get();

            // Update Masa Garansi perbaikan
            $jobDetails = $containerDelegationFromVendor->details;
            foreach ($jobDetails as $jDetail) {
                // if contract is exists
                if ($jDetail->delegationToVendorDetail) {

                    list($dateStart, $dateEnd) = $this->contractRepository->calculateWarrantyFromDate($jDetail->delegationToVendorDetail->containerDelegation->contract, $containerDelegationFromVendor->action_date);

                    if ($containerDelegationFromVendor->job_type == JobTypeEnum::UPGRADE_AND_REPAIR) {

                        foreach ($containers as $container) {
                            $container->upgrade_warranty_start_date = $dateStart;
                            $container->upgrade_warranty_end_date = $dateEnd;
                            $container->save();
                        }

                    }

                    foreach ($jDetail->sub as $sub) {
                        // Hitung masa garansi dari service
                        // Jika maintenance, update per item perbaikan.
                        if ($containerDelegationFromVendor->job_type == JobTypeEnum::MAINTENANCE) {
                            $sub->warranty_start_date = $dateStart;
                            $sub->warranty_end_date = $dateEnd;
                            $sub->save();
                        }
                    }
                }

                // is_done = true
                $jDetail->delegationToVendorDetail->is_done = true;
                $jDetail->delegationToVendorDetail->save();

            }
            if ($containers) {
                foreach ($containers as $container) {
                    //If any updated records, dont change CT status
                    $containerRecords = Record::where('container_code', $container->code)
                        ->where('action_date', '>', $containerDelegationFromVendor->action_date)
                        ->get();

                    if ($containerRecords->count() < 1) {
                        // throw new Exception("Error: Terdapat CT yang sudah diproses di transaksi lain.");
                        $container->updateStatusByCode('SO');
                    }
                }
            }
        }
        DB::commit();
    }

    public function reject(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        $admin = Admin::where('id', Auth::id())->first();

        if ($admin->role == 'Administrator' || $admin->role == 'Supervisor' && $containerDelegationFromVendor->status == StatusEnum::POSTED) {
            $containerDelegationFromVendor->status = 'DRAFT';
            $containerDelegationFromVendor->last_updated_by = Auth::id();
            $containerDelegationFromVendor->save();

            // is_done FALSE
            $details = [];
            $details = $containerDelegationFromVendor->details()->get();

            if ($details) {
                foreach ($details as $detail) {
                    ContainerDelegationDetail::where('id', $detail->container_delegation_detail_id)->update([
                        'is_done' => false
                    ]);
                }
            }

            // Send Email Notification to CTC Supervisor
            Admin::where('role', RoleEnum::CHECKER)->get()->each(function (Admin $admin) use ($containerDelegationFromVendor) {
                Mail::to($admin)->send(new DelegationFromVendorRejectEmail($containerDelegationFromVendor));
            });
        }
    }

    public function getDataTableQuery()
    {
        $query = ContainerDelegationFromVendor::withoutTrashed()->with(['location', 'vendor', 'createdByUser'])->select('container_delegation_from_vendors.*');

        if (Auth::check()) {
            if (Auth::user()->hasOnlyRole(RoleEnum::SUPERVISOR)) {
                $query->where('status', StatusEnum::POSTED);
            }
        }

        return $query;
    }

    public function updateProgress(ContainerDelegationFromVendor $containerDelegationFromVendor)
    {
        $fromVendorDetail = ContainerDelegationFromVendorDetail::where('from_vendor_id', $containerDelegationFromVendor->id)->get();

        if ($fromVendorDetail) {
            foreach ($fromVendorDetail as $detail) {
                $detail->update([
                    'progress' => 100
                ]);
            }
        }
    }

    public function detailDestroy(ContainerDelegationFromVendorDetail $containerDelegationFromVendorDetail)
    {
        DB::beginTransaction();


        if (!empty($containerDelegationFromVendorDetail->images)) {
            foreach ($containerDelegationFromVendorDetail->images as $img) {
                Storage::delete($img);
            }
        }

        foreach ($containerDelegationFromVendorDetail->sub as $subDetail) {
            // if(!empty($subDetail->images)){
            //     foreach ($subDetail->images as $img) {
            //         Storage::delete($img);
            //     }
            // }

            if (!empty($subDetail->images_after)) {
                foreach ($subDetail->images_after as $img) {
                    if ($img) {
                        Storage::delete($img);
                    }
                }
            }
        }


        $containerDelegationFromVendorDetail->sub()->delete();

        $containerDelegationFromVendorDetail->delete();

        DB::commit();
    }

    public function duplicateSubDetail($subDetailId)
    {
        $subDetail = ContainerDelegationFromVendorSubDetail::where('id', $subDetailId)->first();

        $newSub = new ContainerDelegationFromVendorSubDetail;
        $newSub->ct_from_vendor_detail_id = $subDetail->ct_from_vendor_detail_id;
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
        $newSub->images_after = $subDetail->images_after;
        $newSub->save();
    }
}