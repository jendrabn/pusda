<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\PreventModificationOfIdOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TabelBps extends Model
{
	use HasFactory, Auditable, PreventModificationOfIdOne;

	protected $table = 'tabel_bps';

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

	public function uraianBps(): HasMany
	{
		return $this->hasMany(UraianBps::class, 'tabel_bps_id', 'id');
	}

	public function fiturBps(): HasOne
	{
		return $this->hasOne(FiturBps::class, 'tabel_Bps_id', 'id');
	}

	public function fileBps(): HasMany
	{
		return $this->hasMany(FileBps::class, 'tabel_bps_id', 'id');
	}
}
