<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
  use HasFactory, Auditable;

  protected $table = 'skpd';

  protected $fillable = [
    'nama',
    'singkatan',
    'kategori_skpd_id'
  ];

  public function users()
  {
    return $this->hasMany(User::class, 'user_id');
  }

  public function kategori()
  {
    return $this->belongsTo(KategoriSkpd::class, 'kategori_skpd_id');
  }

  public function tabelRpjmd()
  {
    return $this->hasMany(TabelRpjmd::class, 'skpd_id');
  }

  public function tabel8Keldata()
  {
    return $this->hasMany(Tabel8KelData::class, 'skpd_id');
  }

  public function uraianRpjmd()
  {
    return $this->hasMany(UraianRpjmd::class, 'skpd_id');
  }

  public function uraian8KelData()
  {
    return $this->hasMany(Uraian8KelData::class, 'skpd_id');
  }

  public function sumberData()
  {
    return $this->hasMany(Uraian8KelData::class, 'sumber_data', 'id');
  }
}
