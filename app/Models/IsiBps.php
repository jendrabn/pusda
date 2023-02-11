<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiBps extends Model
{
  use HasFactory, Auditable;

  protected $table = 'isi_bps';

  protected $fillable = [
    'uraian_bps_id',
    'tahun',
    'isi'
  ];

  public function uraianBps()
  {
    return $this->belongsTo(UraianBps::class, 'uraian_bps_id');
  }
}
