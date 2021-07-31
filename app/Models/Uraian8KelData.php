<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uraian8KelData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'uraian_8keldata';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'parent_id',
        'skpd_id',
        'tabel_8keldata_id',
        'uraian',
        'satuan',
        'ketersediaan_data',
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

    public function tabel8KelData()
    {
        return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id');
    }

    public function isi8KelData()
    {
        return $this->hasMany(Isi8KelData::class, 'uraian_8keldata_id');
    }

    public static function getUraianByTableId($id)
    {
        $uraian8KelData = self::with('isi8KelData')->where('tabel_8keldata_id', $id)->get();

        $years = Isi8KelData::getYears($id);

        $uraian8KelData->each(function ($uraian) use ($years) {
            if ($uraian->parent_id) {
                foreach ($years as $year) {
                    $isi = $uraian->isi8KelData->where('tahun', $year)->first();
                    if (is_null($isi)) {
                        Isi8KelData::create([
                            'uraian_8keldata_id' => $uraian->id,
                            'tahun' => $year,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });

        $uraian8KelData = self::with('childs.isi8KelData')->where('tabel_8keldata_id', $id)->whereNull('parent_id')->get();

        return $uraian8KelData;
    }
}
