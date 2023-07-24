<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Uwla\Lacl\Contracts\HasPermissionContract;
use Uwla\Lacl\Contracts\HasRoleContract;
use Uwla\Lacl\Traits\PermissionableHasRole;

class User
extends Authenticatable
implements HasPermissionContract, HasRoleContract, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, PermissionableHasRole;

    // ─────────────────────────────────────────────────────────────────────────
    // ATTRIBUTES

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
     * Encrypt the password.
     *
     * @param $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ACCESS CONTROL

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
     * Get the role class for ACL.
     *
     * @return string
     */
    public static function Role()
    {
        return \App\Models\Role::class;
    }
    /**
     * Get the permission class for ACL.
     *
     * @return string
     */
    public static function Permission()
    {
        return \App\Models\Permission::class;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // NOTIFICATIONS

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
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // VOTES

    /**
     * Upvote a grupo.
     *
     * @param Grupo $grupo
     * @return void
     */
    public function upvote(Grupo $grupo)
    {
        $this->unvote($grupo);
        Vote::create([
            'vote' => true,
            'user_id' => $this->id,
            'grupo_id' => $grupo->id,
        ]);
    }

    /**
     * Downvote a grupo.
     *
     * @param Grupo $grupo
     * @return void
     */
    public function downvote(Grupo $grupo)
    {
        $this->unvote($grupo);
        Vote::create([
            'vote' => false,
            'user_id' => $this->id,
            'grupo_id' => $grupo->id,
        ]);
    }

    /**
     * Revoke grupo vote.
     *
     * @param Grupo $grupo
     * @return void
     */
    public function unvote(Grupo $grupo)
    {
        Vote::where([
            'user_id' => $this->id,
            'grupo_id' => $grupo->id,
        ])->delete();
    }

    /**
     * Get this User's votes.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'user_id');
    }
}
