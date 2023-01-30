<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiturIndikator extends Model
{
  use HasFactory, Auditable;

  protected $table = 'fitur_indikator';

  protected $fillable = [
    'tabel_indikator_id',
    'deskripsi',
    'analisis',
    'permasalahan',
    'solusi',
    'saran'
  ];

  public function tabelIndikator()
  {
    return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id');
  }
}
