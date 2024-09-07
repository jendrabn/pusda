<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiturRpjmd extends Model
{
	use HasFactory, Auditable;

	protected $table = 'fitur_rpjmd';

	protected $fillable = [
		'tabel_rpjmd_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'saran',
		'solusi'
	];

	public function tabelRpjmd(): BelongsTo
	{
		return $this->belongsTo(Tabel8KelData::class, 'tabel_rpjmd_id', 'id');
	}

}
