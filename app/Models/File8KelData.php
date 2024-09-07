<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File8KelData extends Model
{
	use HasFactory, Auditable;

	protected $table = 'file_8keldata';

	protected $fillable = [
		'tabel_8keldata_id',
		'nama',
		'size',
	];

	public function tabel8KelData(): BelongsTo
	{
		return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id', 'id');
	}

	public function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
