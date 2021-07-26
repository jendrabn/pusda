<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'skpd_id',
        'name',
        'username',
        'email',
        'no_hp',
        'alamat',
        'avatar',
        'level',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['role'];


    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id');
    }

    public function userLogs()
    {
        return $this->hasMany(UserLog::class, 'user_id');
    }

    /**
     * Get (work with Storage Facade) avatar path.
     * 
     * @return string
     */
    public function getAvatarPathAttribute()
    {
        return str_replace('storage/', '', $this->avatar);
    }

    /**
     * Provide profile url.
     * 
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if (Storage::disk('public')->has($this->avatar_path)) {
            return asset($this->avatar);
        }

        return asset('assets/img/avatar-default.png');
    }

    public function getRoleAttribute()
    {
        return $this->level == 1 ? 'Administrator' : 'SKPD';
    }
}
