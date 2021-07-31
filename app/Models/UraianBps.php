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
        $uraianBps = self::with('isiBps')->where('tabel_bps_id', $id)->get();

        $years = IsiBps::getYears($id);

        $uraianBps->each(function ($uraian) use ($years) {
            foreach ($years as $year) {
                if ($uraian->parent_id) {
                    $isiBps = $uraian->isiBps->where('tahun', $year)->first();
                    if (is_null($isiBps)) {
                        IsiBps::create([
                            'uraian_bps_id' => $uraian->id,
                            'tahun' => $year,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });

        return self::with('childs.isiBps')->where('tabel_bps_id', $id)->whereNull('parent_id')->get();
    }
}
