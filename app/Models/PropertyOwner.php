<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyOwner extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function property() : HasOne
    {
        return $this->hasOne(Property::class, 'id', 'property_id');
    }
}
