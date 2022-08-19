<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileRpjmd extends Model
{
    use HasFactory, Auditable;

    protected $table = 'file_rpjmd';

    protected $fillable = [
        'tabel_rpjmd_id',
        'file_name'
    ];

    public function tabelRpjmd()
    {
        return $this->belongsTo(TabelRpjmd::class, 'tabel_rpjmd_id');
    }
}
