<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelBps extends Model
{
  use HasFactory, Auditable;

  protected $table = 'tabel_bps';

  protected $fillable = ['id', 'parent_id', 'nama_menu'];

  public function parent()
  {
    return $this->belongsTo(self::class, 'parent_id');
  }

  public function childs()
  {
    return $this->hasMany(self::class, 'parent_id');
  }

  public function uraianBps()
  {
    return $this->hasMany(UraianBps::class, 'tabel_bps_id');
  }

  public function fiturBps()
  {
    return $this->hasOne(FiturBps::class, 'tabel_Bps_id');
  }

  public function fileBps()
  {
    return $this->hasMany(FileBps::class, 'tabel_bps_id');
  }
}
