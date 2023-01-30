<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileIndikator extends Model
{
  use HasFactory, Auditable;

  protected $table = 'file_indikator';

  protected $fillable = [
    'tabel_indikator_id',
    'nama',
    'path'
  ];

  public function tabelIndikator()
  {
    return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id');
  }
}
