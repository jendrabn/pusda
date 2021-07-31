<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiBps extends Model
{
    use HasFactory;

    protected $table = 'isi_bps';

    protected $fillable = [
        'uraian_bps_id',
        'tahun',
        'isi'
    ];

    public function uraianBps()
    {
        return $this->belongsTo(UraianBps::class, 'uraian_bps_id');
    }

    public static function getYears($tabelBpsId)
    {
        $years = self::select('tahun')->whereHas('uraianBps', function ($query) use ($tabelBpsId) {
            $query->where('tabel_bps_id', '=', $tabelBpsId);
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
