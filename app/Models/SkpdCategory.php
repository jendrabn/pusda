<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkpdCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function skpd()
    {
        return $this->hasMany(Skpd::class, 'skpd_category_id');
    }
}
