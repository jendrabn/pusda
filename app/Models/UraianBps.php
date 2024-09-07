<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UraianBps extends Model
{
	use HasFactory, Auditable;

	protected $table = 'uraian_bps';

	protected $fillable = [
		'id',
		'parent_id',
		'skpd_id',
		'tabel_bps_id',
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

	public function tabelBps(): BelongsTo
	{
		return $this->belongsTo(tabelBps::class, 'tabel_bps_id', 'id');
	}

	public function isiBps(): HasMany
	{
		return $this->hasMany(IsiBps::class, 'uraian_bps_id', 'id');
	}
}
