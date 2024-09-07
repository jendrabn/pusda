<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\PreventModificationOfIdOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TabelRpjmd extends Model
{
	use HasFactory, Auditable, PreventModificationOfIdOne;

	protected $table = 'tabel_rpjmd';

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

	public function fiturRpjmd(): HasOne
	{
		return $this->hasOne(FiturRpjmd::class, 'tabel_rpjmd_id', 'id');
	}

	public function uraianRpjmd(): HasMany
	{
		return $this->hasMany(UraianRpjmd::class, 'tabel_rpjmd_id', 'id');
	}

	public function fileRpjmd(): HasMany
	{
		return $this->hasMany(FileRpjmd::class, 'tabel_rpjmd_id', 'id');
	}
}
