<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File8KelData extends Model
{
    use HasFactory;

    protected $table = 'file_8keldata';

    protected $fillable = [
        'tabel_8keldata_id',
        'file_name'
    ];

    public function tabel8KelData()
    {
        return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id');
    }
}
