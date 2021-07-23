<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileRpjmd extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_rpjmd';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tabel_rpjmd_id',
        'file_name'
    ];

    public function tabelRpjmd()
    {
        return $this->belongsTo(TabelRpjmd::class, 'tabel_rpjmd_id');
    }
}
