<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\PreventModificationOfIdOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skpd extends Model
{
	use HasFactory, Auditable, PreventModificationOfIdOne;

	protected $table = 'skpd';

	protected $fillable = [
		'nama',
		'singkatan',
		'kategori_skpd_id'
	];

	public function users(): HasMany
	{
		return $this->hasMany(User::class, 'user_id', 'id');
	}

	public function kategori(): BelongsTo
	{
		return $this->belongsTo(KategoriSkpd::class, 'kategori_skpd_id', 'id');
	}

	public function tabelRpjmd(): HasMany
	{
		return $this->hasMany(TabelRpjmd::class, 'skpd_id', 'id');
	}

	public function tabel8Keldata(): HasMany
	{
		return $this->hasMany(Tabel8KelData::class, 'skpd_id', 'id');
	}

	public function uraianRpjmd(): HasMany
	{
		return $this->hasMany(UraianRpjmd::class, 'skpd_id', 'id');
	}

	public function uraian8KelData(): HasMany
	{
		return $this->hasMany(Uraian8KelData::class, 'skpd_id', 'id');
	}

	public function sumberData(): HasMany
	{
		return $this->hasMany(Uraian8KelData::class, 'sumber_data', 'id');
	}

	protected function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
