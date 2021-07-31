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
        $uraianRpjmd = self::with('isiRpjmd')->where('tabel_rpjmd_id', $id)->get();

        $years = IsiRpjmd::getYears($id);

        $uraianRpjmd->each(function ($uraian) use ($years) {
            if ($uraian->parent_id) {
                foreach ($years as $year) {
                    $isiRpjmd = $uraian->isiRpjmd->where('tahun', $year)->first();
                    if (is_null($isiRpjmd)) {
                        IsiRpjmd::create([
                            'uraian_rpjmd_id' => $uraian->id,
                            'tahun' => $year,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });

        return self::with('childs.isiRpjmd')->where('tabel_rpjmd_id', $id)->whereNull('parent_id')->get();
    }
}
