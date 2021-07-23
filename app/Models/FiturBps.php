<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiturBps extends Model
{
	use HasFactory;

	protected $table = 'fitur_bps';

	protected $fillable = [
		'tabel_bps_id',
		'deskripsi',
		'analisis',
		'permasalahan',
		'solusi',
		'saran'
	];

	public function tabelBps()
	{
		return $this->belongsTo(TabelBps::class, 'tabel_bps_id');
	}

	public static function getFiturByTableId($id)
	{
		$fiturBps = self::where('tabel_bps_id', $id)->first();

		if (is_null($fiturBps)) {
			$fiturBps = self::create([
				'tabel_bps_id' => $id
			]);
		}

		return $fiturBps;
	}
}
