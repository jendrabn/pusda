<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileIndikator extends Model
{
	use HasFactory, Auditable;

	protected $table = 'file_indikator';

	protected $fillable = [
		'tabel_indikator_id',
		'nama',
		'size',
	];

	public function tabelIndikator(): BelongsTo
	{
		return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id', 'id');
	}

	public function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
