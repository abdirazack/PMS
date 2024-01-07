<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Filament\Models\Concerns\IsFilamentUser;
use Filament\Models\Contracts\FilamentUser;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    use SoftDeletes;
    // use IsFilamentUser;
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function isAdmin()
    {
        return $this->role == 'admin';
    }
    public function roles() : HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function propertyOwner()
    {
        return $this->hasOne(PropertyOwner::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }


        /**
     * Hash the password on save/update.
    */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }


}
