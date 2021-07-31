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
        $uraianIndikator = self::with('isiIndikator')->where('tabel_indikator_id', $id)->get();

        $years = IsiIndikator::getYears($id);

        $uraianIndikator->each(function ($uraian) use ($years) {
            foreach ($years as $year) {
                if ($uraian->parent_id) {
                    $isiIndikator = $uraian->isiIndikator->where('tahun', $year)->first();
                    if (is_null($isiIndikator)) {
                        IsiIndikator::create([
                            'uraian_indikator_id' => $uraian->id,
                            'tahun' => $year,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });

        return self::with('childs.isiIndikator')->where('tabel_indikator_id', $id)->whereNull('parent_id')->get();
    }
}
