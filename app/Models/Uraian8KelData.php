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
        $uraian8KelData = self::where('tabel_8keldata_id', $id)->get();

        if ($uraian8KelData->isNotEmpty()) {
            $date = date('Y');
            $i = $date - 4;
            $uraian8KelData->each(function ($item) use ($i, $date) {
                if (!is_null($item->parent_id)) {
                    for ($dateList = $i; $dateList <= $date;) {
                        $isi8KelData = Isi8KelData::where('uraian_8keldata_id', $item->id)
                            ->where('tahun', $dateList)
                            ->first();
                        if ($isi8KelData === null) {
                            Isi8KelData::create([
                                'uraian_8keldata_id' => $item->id,
                                'tahun' => $dateList,
                                'isi' => 0
                            ]);
                        }
                        $dateList++;
                    }
                }
            });
        }

        $uraian8KelData = self::where('tabel_8keldata_id', $id)->whereNull('parent_id')->get();
        return $uraian8KelData;
    }
}
