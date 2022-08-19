<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'os', 'browser'];

    public function getDayCountAttribute()
    {
        return $this->whereDay('created_at', Carbon::today())->count();
    }

    public function getMonthCountAttribute()
    {
        return $this->whereMonth('created_at', Carbon::now()->month)->count();
    }

    public function getYearCountAttribute()
    {
        return $this->whereYear('created_at', Carbon::now()->year)->count();
    }

    public function getAllCountAttribute()
    {
        return $this->all()->count();
    }
}
