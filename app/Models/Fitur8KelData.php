<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitur8KelData extends Model
{
    use HasFactory, Auditable;

    protected $table = 'fitur_8keldata';

    protected $fillable = [
        'tabel_8keldata_id',
        'deskripsi',
        'analisis',
        'permasalahan',
        'solusi',
        'saran',
    ];

    public function tabel8KelData()
    {
        return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id');
    }

    public static function getFiturByTableId($id)
    {
        $fitur8KelData = self::where('tabel_8keldata_id', $id)->first();

        if (is_null($fitur8KelData)) {
            $fitur8KelData =  self::create([
                'tabel_8keldata_id' => $id
            ]);
        }

        return $fitur8KelData;
    }
}
