<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSkpd extends Model
{
    use HasFactory;

    protected $table = 'kategori_skpd';

    protected $fillable = ['nama'];

    public function skpd()
    {
        return $this->hasMany(Skpd::class, 'kategori_skpd_id');
    }
}
