<?php

namespace App\Repositories\Console;

use App\Models\Contract;
use App\Models\Container;
use Mockery\Matcher\Contains;
use Illuminate\Support\Carbon;
use App\Models\ContainerDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContainerRepository
{
    public function __contstruct() {}

    public function store($data)
    {
        $photos = $data['photos'] ?? [];
        // clean up
        unset($data['photos']);

        if ($data['down_location_id'] == '-') {
            $data['down_location_id'] = null;
            // $data['down_at'] = null;
            // $data['down_carriage_no'] = null;
        } else {
            $data['down_at'] = $data['buy_date'];
        }

        // record
        DB::beginTransaction();
        $data['created_by'] = Auth::id();

        if ($data['contract_id']) {
            $contract = Contract::where('id', $data['contract_id'])->first();

            if ($contract->warranty_in_days != null || $contract->warranty_in_days != '') {
                $data['warranty_date_start'] = $data['buy_date'];
                $data['warranty_date_end'] = Carbon::parse($data['buy_date'])->addDays($contract->warranty_in_days)->toDateString();
            } elseif ($contract->warranty_in_month != null || $contract->warranty_in_month != '') {
                $data['warranty_date_start'] = $data['buy_date'];
                $data['warranty_date_end'] = Carbon::parse($data['buy_date'])->addMonths($contract->warranty_in_month)->toDateString();
            } elseif ($contract->warranty_date_start != null || $contract->warranty_date_start != '' && $contract->warranty_date_end != null || $contract->warranty_date_end != '') {
                $data['warranty_date_start']  = $contract->warranty_date_start;
                $data['warranty_date_end'] = $contract->warranty_date_end;
            }
        }

        $container = Container::create($data);

        // TODO : photo upload
        if (request()->hasFile('photos')) {
            if (count($photos) > 0) {
                foreach ($photos as $key => $photo) {
                    $uploadLocation = $photo->storePublicly('containers/documents');

                    $document = new ContainerDocument;
                    $document->container_code = $container->code;
                    $document->file_name = $photo->getClientOriginalName();
                    $document->document_location = $uploadLocation;
                    $document->mimeType = $photo->getClientMimeType();
                    $document->extension = $photo->extension();
                    $document->size = $photo->getSize();
                    $document->save();
                }
            }
        }

        DB::commit();
    }

    public function dataTableQuery()
    {
        return Container::withoutTrashed()->with('status', 'company', 'vendor', 'lastUpgradeVendor', 'lastMaintenanceVendor', 'createdByUser');
    }

    public function update(string $code, $data)
    {
        $container = Container::where('code', $code)->first();

        //set up > down if update status to O

        if ($data['container_status_id'] == '1') {
            $downAt = $container->down_at ? Carbon::parse($container->down_at) : now();
            // Only update up_at if it's null or <= downAt
            if (!$container->up_at || Carbon::parse($container->up_at)->lte($downAt)) {
                $data['up_at'] = $downAt->copy()->addHour();
            }
        }

        //UPDATED FOR CONSISTENCY STATUS

        // if ($data['down_location_id'] == '-') {
        //     $data['down_location_id'] = null;
        //     // $data['down_at'] = null;
        //     // $data['down_carriage_no'] = null;
        // } else {
        //     $data['down_at'] = $data['buy_date'];
        // }


        // TODO : photo upload
        if (request()->hasFile('photos')) {
            request()->validate([
                'photos' => 'nullable|array',
            ]);

            $photos = request('photos');
            unset($photos);

            if (count(request('photos')) > 0) {
                $document = ContainerDocument::where('container_code', $code)->first();

                if ($document) {
                    Storage::delete($document->document_location);
                }

                foreach (request('photos') as $key => $photo) {
                    $uploadLocation = $photo->storePublicly('containers/documents');

                    if ($document) {
                        $document->container_code = $code;
                        $document->file_name = $photo->getClientOriginalName();
                        $document->document_location = $uploadLocation;
                        $document->mimeType = $photo->getClientMimeType();
                        $document->extension = $photo->extension();
                        $document->size = $photo->getSize();
                        $document->save();
                    } else {
                        $document = new ContainerDocument;
                        $document->container_code = $code;
                        $document->file_name = $photo->getClientOriginalName();
                        $document->document_location = $uploadLocation;
                        $document->mimeType = $photo->getClientMimeType();
                        $document->extension = $photo->extension();
                        $document->size = $photo->getSize();
                        $document->save();
                    }
                }
            }
        }
        // dd($data);
        $container->update($data);
    }

    public function destroy(int $code)
    {
        $container = Container::find($code);

        if ($container) {
            $document = ContainerDocument::where('container_code', $code)->first();

            if ($document) {
                Storage::delete($document->document_location);

                $document->delete();
            }

            $container->delete();
        }
    }
}
