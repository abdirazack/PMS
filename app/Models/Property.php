<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $guarded = [];

    public function propertyOwner()
    {
        return $this->hasOne(PropertyOwner::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

}
