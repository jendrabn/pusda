<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiRpjmd extends Model
{
    use HasFactory;

    protected $table = 'isi_rpjmd';

    protected $fillable = [
        'uraian_rpjmd_id',
        'tahun',
        'isi'
    ];

    public function uraianRpjmd()
    {
        return $this->belongsTo(UraianRpjmd::class, 'uraian_rpjmd_id');
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
