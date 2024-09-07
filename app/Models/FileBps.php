<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileBps extends Model
{
	use HasFactory, Auditable;

	protected $table = 'file_bps';

	protected $fillable = [
		'tabel_bps_id',
		'nama',
		'size',
	];

	public function tabelBps(): BelongsTo
	{
		return $this->BelongsTo(TabelBps::class, 'tabel_bps_id', 'id');
	}

	public function serializeDate(\DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
