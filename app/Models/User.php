<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use HasFactory, Notifiable, Auditable, HasRoles;

	public const ROLE_ADMIN = 'Administrator';
	public const ROLE_SKPD = 'SKPD';

	public const ROLES = [
		self::ROLE_ADMIN,
		self::ROLE_SKPD
	];

	protected $fillable = [
		'skpd_id',
		'name',
		'username',
		'email',
		'role',
		'phone',
		'address',
		'avatar',
		'birth_date',
		'password',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed'
	];

	public function skpd(): BelongsTo
	{
		return $this->belongsTo(Skpd::class, 'skpd_id', 'id',);
	}

	public function avatarUrl(): Attribute
	{
		return Attribute::get(fn () => $this->attributes['avatar'] && Storage::disk('public')->exists($this->attributes['avatar'])
			? Storage::url($this->attributes['avatar'])
			: 'https://ui-avatars.com/api/?name=' . urlencode($this->attributes['name']));
	}

	public function isAdministrator(): bool
	{
		return $this->attributes['role'] === self::ROLE_ADMIN;
	}

	public function isSkpd(): bool
	{
		return $this->attributes['role'] === self::ROLE_SKPD;
	}
}
