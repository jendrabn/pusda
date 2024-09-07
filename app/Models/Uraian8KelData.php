<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uraian8KelData extends Model
{
	use HasFactory, Auditable;

	protected $table = 'uraian_8keldata';

	protected $fillable = [
		'id',
		'parent_id',
		'skpd_id',
		'tabel_8keldata_id',
		'uraian',
		'satuan',
		'ketersediaan_data',
	];

	protected $casts = [
		'ketersediaan_data' => 'boolean',
	];

	public function parent(): BelongsTo
	{
		return $this->belongsTo(self::class, 'parent_id', 'id');
	}

	public function childs(): HasMany
	{
		return $this->hasMany(self::class, 'parent_id', 'id');
	}

	public function skpd(): BelongsTo
	{
		return $this->belongsTo(Skpd::class, 'skpd_id', 'id');
	}

	public function tabel8KelData(): BelongsTo
	{
		return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id', 'id');
	}

	public function isi8KelData(): HasMany
	{
		return $this->hasMany(Isi8KelData::class, 'uraian_8keldata_id', 'id');
	}

	public function LabelKetersediaanData(): Attribute
	{
		return Attribute::get(fn() => match ($this->attributes['ketersediaan_data']) {
			1 => 'Tersedia',
			0 => 'Tidak Tersedia',
			default => ''
		});
	}

	public function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('d-m-Y H:i:s');
	}
}
