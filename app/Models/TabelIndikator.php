<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelIndikator extends Model
{
  use HasFactory, Auditable;

  protected $table = 'tabel_indikator';

  protected $fillable = ['id', 'parent_id', 'nama_menu'];

  public function parent()
  {
    return $this->belongsTo(self::class, 'parent_id');
  }

  public function childs()
  {
    return $this->hasMany(self::class, 'parent_id');
  }

  public function uraianIndikator()
  {
    return $this->hasMany(UraianIndikator::class, 'tabel_indikator_id');
  }

  public function fiturIndikator()
  {
    return $this->hasOne(FiturIndikator::class, 'tabel_indikator_id');
  }

  public function fileIndikator()
  {
    return $this->hasMany(FileIndikator::class, 'tabel_indikator_id');
  }
}
