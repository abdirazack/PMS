<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'permissions'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    // cast
    protected $casts = [
        'permissions' => 'array'
    ];
    // mutator
    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = json_encode($value);
    }
    // accessor
    public function getPermissionsAttribute($value)
    {
        return $this->attributes['permissions'] = json_decode($value);
    }
    
}
