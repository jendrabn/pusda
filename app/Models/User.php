<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
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
		'phone',
		'address',
		'photo',
		'birth_date',
		'role',
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
		return $this->belongsTo(Skpd::class, 'skpd_id');
	}

	public function photo(): Attribute
	{
		return Attribute::get(fn($value) => $value && Storage::disk('public')->exists($value) ? Storage::url($value) : '/img/default-avatar.jpg');
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
