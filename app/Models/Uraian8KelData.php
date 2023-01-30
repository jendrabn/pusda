<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uraian8KelData extends Model
{
  use HasFactory, Auditable;

  protected $table = 'uraian_8keldata';

  protected $fillable = [
    'id',
    'parent_id',
    'skpd_id',
    'tabel_8keldata_id',
    'uraian',
    'satuan',
    'ketersediaan_data',
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

  public function tabel8KelData()
  {
    return $this->belongsTo(Tabel8KelData::class, 'tabel_8keldata_id');
  }

  public function isi8KelData()
  {
    return $this->hasMany(Isi8KelData::class, 'uraian_8keldata_id');
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
