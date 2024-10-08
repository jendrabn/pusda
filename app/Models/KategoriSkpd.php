<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSkpd extends Model
{
	use HasFactory, Auditable;

	protected $table = 'kategori_skpd';

	protected $fillable = ['nama'];

	public function skpd(): HasMany
	{
		return $this->hasMany(Skpd::class, 'kategori_skpd_id', 'id');
	}
}
