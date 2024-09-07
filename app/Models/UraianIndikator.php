<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UraianIndikator extends Model
{
	use HasFactory, Auditable;

	protected $table = 'uraian_indikator';

	protected $fillable = [
		'id',
		'parent_id',
		'skpd_id',
		'tabel_indikator_id',
		'uraian',
		'satuan'
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

	public function tabelIndikator(): BelongsTo
	{
		return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id', 'id');
	}

	public function isiIndikator(): HasMany
	{
		return $this->hasMany(IsiIndikator::class, 'uraian_indikator_id', 'id');
	}
}
