<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiturRpjmd extends Model
{
	use HasFactory;

	protected $table = 'fitur_rpjmd';

	protected $fillable = [
		'tabel_rpjmd_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'saran',
		'solusi'
	];

	public function tabelRpjmd()
	{
		return $this->belongsTo(Tabel8KelData::class, 'tabel_rpjmd_id');
	}

	public static function getFiturByTableId($id)
	{
		$fiturRpjmd = self::where('tabel_rpjmd_id', $id)->first();

		if (is_null($fiturRpjmd)) {
			$fiturRpjmd = self::create([
				'tabel_rpjmd_id' => $id
			]);
		}

		return $fiturRpjmd;
	}
}
