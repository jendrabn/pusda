<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiturIndikator extends Model
{
	use HasFactory, Auditable;

	protected $table = 'fitur_indikator';

	protected $fillable = [
		'tabel_indikator_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'solusi',
		'saran'
	];

	public function tabelIndikator(): BelongsTo
	{
		return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id', 'id');
	}

}
