<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isi8KelData extends Model
{
    use HasFactory, Auditable;

    protected $table = 'isi_8keldata';

    protected $fillable = ['uraian_8keldata_id', 'tahun', 'isi'];

    public function uraian8KelData()
    {
        return $this->belongsTo(Uraian8KelData::class, 'uraian_8keldata_id');
    }

    public static function getYears($tabel8KelDataId)
    {

        $years = Isi8KelData::select('tahun')->whereHas('uraian8KelData', function ($query) use ($tabel8KelDataId) {
            $query->where('tabel_8keldata_id', '=', $tabel8KelDataId);
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
