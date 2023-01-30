<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianRpjmd extends Model
{
  use HasFactory, Auditable;

  protected $table = 'uraian_rpjmd';

  protected $fillable = [
    'id',
    'parent_id',
    'skpd_id',
    'tabel_rpjmd_id',
    'uraian',
    'satuan',
    'ketersediaan_data'
  ];


  protected $casts = [
    'ketersediaan_data' => 'boolean',
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

  public function tabelRpjmd()
  {
    return $this->belongsTo(TabelRpjmd::class, 'tabel_8keldata');
  }

  public function isiRpjmd()
  {
    return $this->hasMany(IsiRpjmd::class, 'uraian_rpjmd_id');
  }

  public function StrKetersediaanData(): Attribute
  {
    return Attribute::get(fn () => match ($this->attributes['ketersediaan_data']) {
      1 => 'Tersedia',
      0 => 'Tidak Tersedia',
      default => null
    });
  }
}
