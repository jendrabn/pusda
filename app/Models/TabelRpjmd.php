<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelRpjmd extends Model
{
    use HasFactory, Auditable;

    protected $table = 'tabel_rpjmd';

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

    public function fiturRpjmd()
    {
        return $this->hasMany(FiturRpjmd::class, 'tabel_rpjmd_id');
    }

    public function uraianRpjmd()
    {
        return $this->hasMany(UraianRpjmd::class, 'tabel_rpjmd_id');
    }

    public function fileRpjmd()
    {
        return $this->hasMany(FileRpjmd::class, 'tabel_rpjmd_id');
    }
}
