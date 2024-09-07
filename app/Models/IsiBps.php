<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IsiBps extends Model
{
	use HasFactory, Auditable;

	protected $table = 'isi_bps';

	protected $fillable = [
		'uraian_bps_id',
		'tahun',
		'isi'
	];

	public function uraianBps(): BelongsTo
	{
		return $this->belongsTo(UraianBps::class, 'uraian_bps_id', 'id');
	}
}
