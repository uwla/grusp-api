<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Uwla\Lacl\Traits\PermissionableHasRole;
use Uwla\Lacl\Contracts\HasPermissionContract;
use Uwla\Lacl\Contracts\HasRoleContract;

class User extends Authenticatable implements HasPermissionContract, HasRoleContract, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, PermissionableHasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles of administrators
     *
     * @var array<string>
     */
    protected $administration_roles = [
        'admin',
        'manager'
    ];

    /**
     * Determine whether this user has any administration role
     *
     * @return bool
     */
    public function hasAdministrationRole()
    {
        return $this->hasAnyRole($this->administration_roles);
    }

    /**
     * Encrypt the password.
     *
     * @param $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Send the queued email verification notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Get the role class for ACL.
     *
     * @return string
     */
    public static function Role()
    {
        return Role::class;
    }
    /**
     * Get the permission class for ACL.
     *
     * @return string
     */
    public static function Permission()
    {
        return Permission::class;
    }
}
