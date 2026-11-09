<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'vendor_id',
        'container_status_id',
        'fixed_asset_number',
        'buy_date',
        'last_upgrade_vendor_id',
        'last_maintenance_vendor_id',
        'contract_id',
        'length',
        'height',
        'width',
        'last_upgrade_date',
        'last_maintenance_date',
        'warranty_date_start',
        'warranty_date_end',
        'company_id',
        'down_carriage_no',
        'up_carriage_no',
        'down_location_id',
        'up_location_id',
        'description',
        'created_by',
        'last_type_maintenance',
        'last_progress',
        'last_progress_perncentage',
        'update_warranty_start_date',
        'update_warranty_end_date',
        'up_at',
        'down_at'
    ];

    public function documents()
    {
        return $this->hasMany(ContainerDocument::class, 'container_code', 'code');
    }

    public function status()
    {
        return $this->belongsTo(ContainerStatus::class, 'container_status_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withTrashed();
    }

    public function company()
    {
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function lastUpgradeVendor()
    {
        return $this->belongsTo(Vendor::class, 'last_upgrade_vendor_id', 'id')->withDefault([
            'name' => '-'
        ])->withTrashed();
    }

    public function lastMaintenanceVendor()
    {
        return $this->belongsTo(Vendor::class, 'last_maintenance_vendor_id', 'id')->withDefault([
            'name' => '-'
        ])->withTrashed();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id')->withTrashed();
    }

    public function updateStatusByCode($code)
    {
        $status = ContainerStatus::where('code', $code)->firstOrFail();
        $this->container_status_id = $status->id;
        $this->save();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }

    public function downLocation()
    {
        return $this->belongsTo(Location::class, 'down_location_id', 'id')->withTrashed();
    }

    public function upLocation()
    {
        return $this->belongsTo(Location::class, 'up_location_id', 'id')->withTrashed();
    }

    public function delegationToVendorDetail()
    {
        return $this->hasMany(ContainerDelegationDetail::class, 'container_code', 'code');
    }

    public function delegationFromVendorDetail()
    {
        return $this->hasMany(ContainerDelegationFromVendorDetail::class, 'container_code', 'code');
    }

    public function latestDelegationFromVendorDetail()
    {
        return $this->hasOne(ContainerDelegationFromVendorDetail::class, 'container_code', 'code')->latest();
    }
    public function latestDailyActivityDetail()
    {
        return $this->hasOne(ContainerDailyActivityDetail::class, 'container_code', 'code')->latest();
    }

    public function repairDetail() 
    {
        return $this->hasOne(ContainerRepairDetail::class, 'container_code', 'code')->with('repair');
        // ->latest();
    }

    public function bastToVendor() {
        return $this->hasOne(ContainerDelegationDetail::class, 'container_code', 'code');
    }

    public function latestBastToVendor() {
        return $this->hasOne(ContainerDelegationDetail::class, 'container_code', 'code')->latest();
    }

    public function latestBastFromVendor() {
        return $this->hasOne(ContainerDelegationFromVendorDetail::class, 'container_code', 'code')->latest();
    }

    public function latestInspection(){
        return $this->hasOne(InspectionDetail::class, 'container_code', 'code')->latest();
    }

    public function latestRepair() 
    {
        return $this->hasOne(ContainerRepairDetail::class, 'container_code', 'code')->with('repair')->latest();
    }

    public function inspectionDetail() {
        return $this->hasOne(InspectionDetail::class, 'container_code', 'code');
    }

    public function scopeStatus($query, string $code)
    {
        $query->whereHas('status', function ($q) use ($code) {
            $q->where('code', $code);
        });
    }

    public function scopeStatuses($query, array $code) {
        $query->whereHas('status', function ($q) use ($code) {
            $q->whereIn('code', $code);
        });
    }

    public function createdByUser() {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->withTrashed();
    }
}
