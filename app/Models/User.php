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
        'photo',
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

    public function photoUrl(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->attributes['photo'] && Storage::disk('public')->exists($this->attributes['photo'])) {
                return Storage::url($this->attributes['photo']);
            }

            $UiAvatarParams = [
                'name' =>  $this->attributes['name'][0],
                'size' => 150,
                'background' => '465a65',
                'color' => 'fefefe',
                'length' => 2,
                'font-size' => 0.5,
                'rounded' => false,
                'uppercase' => true,
                'bold' => true,
                'format' => 'png'
            ];

            return 'https://ui-avatars.com/api?' . http_build_query($UiAvatarParams);
        });
    }

    public function roleName(): Attribute
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
