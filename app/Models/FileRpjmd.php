<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileRpjmd extends Model
{
	use HasFactory, Auditable;

	protected $table = 'file_rpjmd';

	protected $fillable = [
		'tabel_rpjmd_id',
		'nama',
		'size',
	];

	public function tabelRpjmd(): BelongsTo
	{
		return $this->belongsTo(TabelRpjmd::class, 'tabel_rpjmd_id', 'id');
	}

	public function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
