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

    public static function getYears($tabelRpjmdId)
    {
        $years = self::select('tahun')->whereHas('uraianRpjmd', function ($query) use ($tabelRpjmdId) {
            $query->where('tabel_rpjmd_id', '=', $tabelRpjmdId);
        })
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->map(function ($year) {
                return $year->tahun;
            });

        return $years;
    }
}
