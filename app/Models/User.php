<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
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
		return $this->belongsTo(Skpd::class, 'skpd_id', 'id');
	}

	public function avatarUrl(): Attribute
	{
		return Attribute::get(function () {
			$avatar = $this->attributes['avatar'];

			return $avatar && Storage::disk('public')->exists($avatar)
				? Storage::url($avatar)
				: 'https://ui-avatars.com/api/?name=' . urlencode($this->attributes['name']);
		});
	}

	protected function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('d-m-Y H:i:s');
	}

	public function birthDate(): Attribute
	{
		return Attribute::make(
			set: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
			get: fn($value) => $value ? Carbon::parse($value)->format('d-m-Y') : null
		);
	}
}
