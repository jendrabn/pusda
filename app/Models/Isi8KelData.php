<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isi8KelData extends Model
{
    use HasFactory;

    protected $table = 'isi_8keldata';

    protected $fillable = ['uraian_8keldata_id', 'tahun', 'isi'];

    public function uraian8KelData()
    {
        return $this->belongsTo(Uraian8KelData::class, 'uraian_8keldata_id');
    }

    public static function getYears($tabel8KelDataId)
    {
        // $years = Isi8KelData::query()
        //     ->join('uraian_8keldata', 'isi_8keldata.uraian_8keldata_id', '=', 'uraian_8keldata.id')
        //     ->join('tabel_8keldata', 'uraian_8keldata.tabel_8keldata_id', '=', 'tabel_8keldata.id')
        //     ->where('tabel_8keldata.id', '=', $tabel8KelDataId)
        //     ->groupBy('tahun')
        //     ->select('tahun')
        //     ->orderBy('tahun')
        //     ->get();

        $years = Isi8KelData::select('tahun')->whereHas('uraian8KelData', function ($query) use ($tabel8KelDataId) {
            $query->where('tabel_8keldata_id', '=', $tabel8KelDataId);
        })
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $years = $years->map(function ($year) {
            return $year->tahun;
        });

        return $years;
    }
}
