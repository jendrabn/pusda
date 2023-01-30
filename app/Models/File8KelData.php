<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File8KelData extends Model
{
  use HasFactory, Auditable;

  protected $table = 'file_8keldata';

  protected $fillable = [
    'tabel_8keldata_id',
    'nama',
    'path'
  ];

  public function tabel8KelData()
  {
    return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id');
  }
}
