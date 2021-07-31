<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiturIndikator extends Model
{
	use HasFactory;

	protected $table = 'fitur_indikator';

	protected $fillable = [
		'tabel_indikator_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'solusi',
		'saran'
	];

	public function tabelIndikator()
	{
		return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id');
	}

	public static function getFiturByTableId($id)
	{
		$fiturIndikator = self::where('tabel_indikator_id', $id)->first();

		if (is_null($fiturIndikator)) {
			$fiturIndikator = FiturIndikator::create([
				'tabel_indikator_id' => $id
			]);
		}

		return $fiturIndikator;
	}
}
