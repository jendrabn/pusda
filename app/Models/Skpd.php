<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;

    protected $table = 'skpd';

    protected $fillable = [
        'nama',
        'singkatan',
        'skpd_category_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
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

    public function skpdCategory()
    {
        return $this->belongsTo(SkpdCategory::class, 'skpd_category_id');
    }

    public function sumberData()
    {
        return $this->hasMany(Uraian8KelData::class, 'sumber_data', 'id');
    }
}
