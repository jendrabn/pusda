<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianBps extends Model
{
    use HasFactory;

    protected $table = 'uraian_bps';

    protected $fillable = [
        'id',
        'parent_id',
        'skpd_id',
        'tabel_bps_id',
        'uraian',
        'satuan'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id');
    }

    public function tabelBps()
    {
        return $this->belongsTo(tabelBps::class, 'tabel_bps_id');
    }

    public function isiBps()
    {
        return $this->hasMany(IsiBps::class, 'uraian_bps_id');
    }

    public static function getUraianByTableId($id)
    {
        $uraianBps = self::where('tabel_bps_id', $id)->get();

        if ($uraianBps->isNotEmpty()) {
            $date = date('Y');
            $i = $date - 4;
            $uraianBps->each(function ($item) use ($i, $date) {
                if (!is_null($item->parent_id)) {
                    for ($dateList = $i; $dateList <= $date;) {
                        $isiBps = IsiBps::where('uraian_bps_id', $item->id)->where('tahun', $dateList)->first();
                        if (is_null($isiBps)) {
                            IsiBps::create([
                                'uraian_bps_id' => $item->id,
                                'tahun' => $dateList,
                                'isi' => 0
                            ]);
                        }
                        $dateList++;
                    }
                }
            });
        }

        $uraianBps = self::where('tabel_bps_id', $id)->whereNull('parent_id')->get();
        return $uraianBps;
    }
}
