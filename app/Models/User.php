<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function avatarUrl(): Attribute
    {
        return Attribute::make(get: function () {
            // dd(Storage::disk('public')->exists('public/' . $this->attributes['avatar']));
            if ($this->attributes['avatar']) {
                return Storage::url($this->attributes['avatar']);
            }

            return  asset('img/avatar-default.png');
        });
    }


    public function photo(): Attribute
    {
        return Attribute::make(get: function () {
            $UiAvatarParams = [
                'name' => ($this->attributes['name'])[0],
                'size' => 150,
                'background' => '465a65',
                'color' => 'fefefe',
                'length' => 2,
                'font-size' => 0.5,
                'rounded' => false,
                'uppercase' => false,
                'bold' => true,
                'format' => 'png'
            ];

            return 'https://ui-avatars.com/api?' . http_build_query($UiAvatarParams);
        });
    }

    public function role_name(): Attribute
    {
        return Attribute::make(get: fn () => self::ROLES[$this->attributes['role']]);
    }

    // public function setPasswordAttribute($input): void
    // {
    //     if ($input) {
    //         $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    //     }
    // }
}
