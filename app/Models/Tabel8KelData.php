<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabel8KelData extends Model
{
  use HasFactory, Auditable;

  protected $table = 'tabel_8keldata';

  protected $fillable = ['id', 'skpd_id', 'parent_id', 'nama_menu'];

  public function parent()
  {
    return $this->belongsTo(self::class, 'parent_id');
  }

  public function childs()
  {
    return $this->hasMany(self::class, 'parent_id');
  }

  public function skpd()
  {
    return $this->belongsTo(Skpd::class, 'skpd_id');
  }

  public function uraian8KelData()
  {
    return $this->hasMany(Uraian8KelData::class, 'tabel_8keldata_id');
  }

  public function fitur8KelData()
  {
    return $this->hasOne(Fitur8KelData::class, 'tabel_8keldata_id');
  }

  public function file8KelData()
  {
    return $this->hasMany(File8KelData::class, 'tabel_8keldata_id');
  }
}
