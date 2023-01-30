<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiRpjmd extends Model
{
  use HasFactory, Auditable;

  protected $table = 'isi_rpjmd';

  protected $fillable = [
    'uraian_rpjmd_id',
    'tahun',
    'isi'
  ];

  public function uraianRpjmd()
  {
    return $this->belongsTo(UraianRpjmd::class, 'uraian_rpjmd_id');
  }
}
