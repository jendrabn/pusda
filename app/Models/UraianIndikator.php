<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianIndikator extends Model
{
  use HasFactory, Auditable;

  protected $table = 'uraian_indikator';

  protected $fillable = [
    'id',
    'parent_id',
    'skpd_id',
    'tabel_indikator_id',
    'uraian',
    'satuan'
  ];

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

  public function tabelIndikator()
  {
    return $this->belongsTo(TabelIndikator::class, 'tabel_indikator_id');
  }

  public function isiIndikator()
  {
    return $this->hasMany(IsiIndikator::class, 'uraian_indikator_id');
  }
}
