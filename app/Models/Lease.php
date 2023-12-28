<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lease extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function property() : HasOne
    {
        return $this->hasOne(Property::class, 'id', 'property_id');
    }

    public function tenant() : HasOne
    {
        return $this->hasOne(Tenant::class, 'id', 'tenant_id');
    }
}
