<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IsiIndikator extends Model
{
	use HasFactory, Auditable;

	protected $table = 'isi_indikator';

	protected $fillable = [
		'uraian_indikator_id',
		'tahun',
		'isi'
	];

	public function uraianIndikator(): BelongsTo
	{
		return $this->belongsTo(UraianIndikator::class, 'uraian_indikator_id', 'id');
	}
}
