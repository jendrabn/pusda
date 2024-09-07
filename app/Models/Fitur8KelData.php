<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fitur8KelData extends Model
{
	use HasFactory, Auditable;

	protected $table = 'fitur_8keldata';

	protected $fillable = [
		'tabel_8keldata_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'solusi',
		'saran',
	];

	public function tabel8KelData(): BelongsTo
	{
		return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id', 'id');
	}
}
