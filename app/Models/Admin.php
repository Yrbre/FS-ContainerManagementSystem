<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'signature', 'username'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getEmailForVerification()
    {
        return "email";
    }

    public function hasRole($value)
    {
        // By Pass if Administrator
        if ($this->role == "Administrator") return true;

        if (is_array($value)) {
            return in_array($this->role, $value);
        } else {
            return $this->role == $value;
        }
    }

    public function hasOnlyRole($value)
    {
        if (is_array($value)) {
            return in_array($this->role, $value);
        } else {
            return $this->role == $value;
        }
    }
}
