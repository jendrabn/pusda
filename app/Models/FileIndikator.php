<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileIndikator extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_indikator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tabel_indikator_id',
        'file_name'
    ];

    public function tabelIndikator()
    {
        return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id');
    }
}
