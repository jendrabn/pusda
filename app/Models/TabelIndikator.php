<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\PreventModificationOfIdOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TabelIndikator extends Model
{
	use HasFactory, Auditable, PreventModificationOfIdOne;

	protected $table = 'tabel_indikator';

	protected $fillable = [
		'id',
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

	public function uraianIndikator(): HasMany
	{
		return $this->hasMany(UraianIndikator::class, 'tabel_indikator_id', 'id');
	}

	public function fiturIndikator(): HasOne
	{
		return $this->hasOne(FiturIndikator::class, 'tabel_indikator_id', 'id');
	}

	public function fileIndikator(): HasMany
	{
		return $this->hasMany(FileIndikator::class, 'tabel_indikator_id', 'id');
	}
}
