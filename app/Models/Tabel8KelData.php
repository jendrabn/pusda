<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\PreventModificationOfIdOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tabel8KelData extends Model
{
	use HasFactory, Auditable, PreventModificationOfIdOne;

	protected $table = 'tabel_8keldata';

	protected $fillable = [
		'id',
		'skpd_id',
		'parent_id',
		'nama_menu'
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

	public function uraian8KelData(): HasMany
	{
		return $this->hasMany(Uraian8KelData::class, 'tabel_8keldata_id', 'id');
	}

	public function fitur8KelData(): HasOne
	{
		return $this->hasOne(Fitur8KelData::class, 'tabel_8keldata_id', 'id');
	}

	public function file8KelData(): HasMany
	{
		return $this->hasMany(File8KelData::class, 'tabel_8keldata_id', 'id');
	}
}
