<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianIndikator extends Model
{
    use HasFactory;

    protected $table = 'uraian_indikator';

    protected $fillable = [
        'id',
        'parent_id',
        'skpd_id',
        'tabel_indikator_id',
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

    public function tabelIndikator()
    {
        return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id');
    }

    public function isiIndikator()
    {
        return $this->hasMany(IsiIndikator::class, 'uraian_indikator_id');
    }

    public static function getUraianByTableId($id)
    {
        $uraianIndikator = self::where('tabel_indikator_id', $id)->get();

        if ($uraianIndikator->isNotEmpty()) {
            $date = date('Y');
            $i = $date - 4;
            $uraianIndikator->each(function ($item) use ($i, $date) {
                if (!is_null($item->parent_id)) {
                    for ($dateList = $i; $dateList <= $date;) {
                        $isiIndikator = IsiIndikator::where('uraian_indikator_id', $item->id)
                            ->where('tahun', $dateList)
                            ->first();
                        if (is_null($isiIndikator)) {
                            IsiIndikator::create([
                                'uraian_indikator_id' => $item->id,
                                'tahun' => $dateList,
                                'isi' => 0
                            ]);
                        }
                        $dateList++;
                    }
                }
            });
        }

        $uraianIndikator = self::where('tabel_indikator_id', $id)->whereNull('parent_id')->get();
        return $uraianIndikator;
    }
}
