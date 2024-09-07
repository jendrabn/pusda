<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FiturBps extends Model
{
	use HasFactory, Auditable;

	protected $table = 'fitur_bps';

	protected $fillable = [
		'tabel_bps_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'solusi',
		'saran'
	];

	public function tabelBps(): BelongsTo
	{
		return $this->belongsTo(TabelBps::class, 'tabel_bps_id', 'id');
	}

}
