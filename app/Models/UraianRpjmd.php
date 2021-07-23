<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianRpjmd extends Model
{
    use HasFactory;

    protected $table = 'uraian_rpjmd';

    protected $fillable = [
        'id',
        'parent_id',
        'skpd_id',
        'tabel_rpjmd_id',
        'uraian',
        'satuan',
        'ketersediaan_data'
    ];


    protected $casts = [
        'ketersediaan_data' => 'boolean',
    ];

    public function getKetersediaanDataTextAttribute()
    {
        $ketersediaanData = $this->ketersediaan_data;
        if ($ketersediaanData === true) {
            return 'Tersedia';
        } else if ($ketersediaanData === false) {
            return 'Tidak Tersedia';
        } else {
            return '';
        }
    }

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

    public function tabelRpjmd()
    {
        return $this->belongsTo(TabelRpjmd::class, 'tabel_8keldata');
    }

    public function isiRpjmd()
    {
        return $this->hasMany(IsiRpjmd::class, 'uraian_rpjmd_id');
    }

    public static function getUraianByTableId($id)
    {

        $uraianRpjmd = self::where('tabel_rpjmd_id', $id)->get();
        if ($uraianRpjmd->isNotEmpty()) {
            $date = date('Y');
            $i = $date - 4;
            $uraianRpjmd->each(function ($item) use ($i, $date) {
                if (!is_null($item->parent_id)) {
                    for ($dateList = $i; $dateList <= $date;) {
                        $isiRpjmd = IsiRpjmd::where('uraian_rpjmd_id', $item->id)
                            ->where('tahun', $dateList)
                            ->first();
                        if (is_null($isiRpjmd)) {
                            IsiRpjmd::create([
                                'uraian_rpjmd_id' => $item->id,
                                'tahun' => $dateList,
                                'isi' => 0
                            ]);
                        }
                        $dateList++;
                    }
                }
            });
        }

        $uraianRpjmd = self::where('tabel_rpjmd_id', $id)->whereNull('parent_id')->get();
        return $uraianRpjmd;
    }
}
