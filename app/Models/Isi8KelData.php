<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isi8KelData extends Model
{
    use HasFactory;

    protected $table = 'isi_8keldata';

    protected $fillable = ['uraian_8keldata_id', 'tahun', 'isi'];

    public function uraian8KelData()
    {
        return $this->belongsTo(Uraian8KelData::class, 'uraian_8keldata_id');
    }

    public static function getYears($limit = 5)
    {
        $years = self::orderByDesc('tahun')
            ->groupBy('tahun')
            ->take($limit)
            ->get('tahun')
            ->sortBy('tahun');
        $years = $years->map(fn ($item) => $item->tahun)->values();
        return $years;
    }
}
