<?php

namespace App\Repositories\Console;

use App\Enums\ContainerStatusEnum;
use Exception;
use App\Enums\StatusEnum;
use App\Models\Container;
use App\Models\Inspection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ContainerDailyActivity;
use App\Models\ContainerDailyActivityDetail;
use App\Models\ContainerDelegationDetail;

class ContainerDailyActivityRepository
{
    public function store(array $data)
    {
        $data['created_by'] = Auth::id();

        return ContainerDailyActivity::create($data);
    }

    public function posted(ContainerDailyActivity $containerDailyActivity)
    {
        // Harus DRAFT
        if ($containerDailyActivity->status != StatusEnum::DRAFT)
            throw new Exception("Status transaksi harus DRAFT");

        // Container Activity Detail
        $containerDailyActivityDetail = ContainerDailyActivityDetail::where('ct_daily_activity_id', $containerDailyActivity->id)->get();

        DB::beginTransaction();

        foreach ($containerDailyActivityDetail as $activityDetail) {
            if ($activityDetail->type == 'Turun Container') {
                // BJI-BBA Turun Container Case
                if (($activityDetail->containerDailyActivity->location_id == 2 || $activityDetail->containerDailyActivity->location_id == 3) && $activityDetail->container->status()->first()->code != ContainerStatusEnum::TSO) {
                    $activityDetail->container->updateStatusByCode('SO');
                } else {
                    $activityDetail->container->updateStatusByCode('TSO');
                }
                $activityDetail->container->update([
                    'down_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'down_carriage_no' => $activityDetail->carriage_number,
                    'down_at' => $activityDetail->containerDailyActivity->action_date,
                ]);
            } elseif ($activityDetail->type == 'Naik Container') {


                $containerStatus = $activityDetail->container->status()->first()->code;

                if ($containerStatus == ContainerStatusEnum::TSO) {
                    $activityDetail->container->updateStatusByCode('TSO');
                } elseif ($containerStatus == ContainerStatusEnum::SO || $containerStatus == ContainerStatusEnum::SOI) {
                    $activityDetail->container->updateStatusByCode('O');
                }


                $activityDetail->container->update([
                    'up_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'up_carriage_no' => $activityDetail->carriage_number,
                    'up_at' => $activityDetail->containerDailyActivity->action_date,
                ]);

            } elseif ($activityDetail->type == 'Putus Gerbong') {
                $activityDetail->container->updateStatusByCode('SO');
                $activityDetail->container->update([
                    'down_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'down_carriage_no' => $activityDetail->carriage_number,
                    'down_at' => $activityDetail->containerDailyActivity->action_date,
                ]);
            } elseif ($activityDetail->type == 'CT-DT') {
                if ($activityDetail->container->status()->first()->code == ContainerStatusEnum::SO) {
                    $activityDetail->container->updateStatusByCode('SO');
                }

                if ($activityDetail->container->status()->first()->code == ContainerStatusEnum::O) {
                    $activityDetail->container->updateStatusByCode('SO');
                }
                $activityDetail->container->update([
                    'down_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'down_carriage_no' => $activityDetail->carriage_number,
                    'down_at' => $activityDetail->containerDailyActivity->action_date,
                ]);
            } elseif ($activityDetail->type == 'Truck Unloading') {
                $activityDetail->container->updateStatusByCode('SOI');
                $activityDetail->container->update([
                    'down_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'down_carriage_no' => $activityDetail->carriage_number,
                    'down_at' => $activityDetail->containerDailyActivity->action_date,
                ]);
            } elseif ($activityDetail->type == 'Container Uplift') {
                $activityDetail->container->updateStatusByCode('O');
                $activityDetail->container->update([
                    'down_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'down_carriage_no' => $activityDetail->carriage_number,
                    'up_at' => $activityDetail->containerDailyActivity->action_date,
                ]);
            } elseif ($activityDetail->type == 'Container Unloading') {
                $activityDetail->container->updateStatusByCode('TSO');
                $activityDetail->container->update([
                    'down_location_id' => $activityDetail->containerDailyActivity->location_id,
                    'down_carriage_no' => $activityDetail->carriage_number,
                    'down_at' => $activityDetail->containerDailyActivity->action_date,
                ]);
            }
        }

        $containerDailyActivity->status = StatusEnum::POSTED;
        $containerDailyActivity->post_date = now();
        $containerDailyActivity->post_by = Auth::id();
        $containerDailyActivity->save();

        DB::commit();
    }

    public function update(ContainerDailyActivity $containerDailyActivity, array $data)
    {
        return $containerDailyActivity->update($data);
    }

    public function destroy(ContainerDailyActivity $containerDailyActivity)
    {
        $containerDailyActivity->details()->delete();
        $containerDailyActivity->delete();
    }

    public function markDraftAsDeleted(ContainerDailyActivity $containerDailyActivity)
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $draftActivities = ContainerDailyActivity::where('status', 'DRAFT')
            ->where('created_at', '<=', $sevenDaysAgo)
            ->get();
        if ($draftActivities) {
            foreach ($draftActivities as $draftActivity) {
                $draftActivity->details()->delete();
                $draftActivity->delete();
            }
        }
    }
}