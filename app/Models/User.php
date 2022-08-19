<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable,  Auditable;

    const ROLES = [
        1 => 'Administrator',
        2 => 'SKPD'
    ];

    protected $fillable = [
        'skpd_id',
        'name',
        'username',
        'email',
        'phone',
        'address',
        'avatar',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id');
    }

    public function getAvatarUrlAttribute()
    {
        $avatar = $this->attributes['avatar'];

        return $avatar && Storage::disk('public')->exists($avatar) ?
            Storage::url($avatar) : asset('img/avatar-default.png');
    }

    public function getRoleNameAttribute(): string
    {
        return self::ROLES[$this->attributes['role']];
    }

    public function setPasswordAttribute($input): void
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
}
