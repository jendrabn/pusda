<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Visitor extends Model
{
  use HasFactory;

  protected $fillable = ['date', 'ip'];

  public $timestamps = false;

  public function dayCount(): Attribute
  {
    return Attribute::get(fn () => $this->whereDay('date', Carbon::today())->count());
  }

  public function monthCount(): Attribute
  {
    return Attribute::get(fn () => $this->whereMonth('date', Carbon::now()->month)->count());
  }

  public function yearCount(): Attribute
  {
    return Attribute::get(fn () => $this->whereYear('date', Carbon::now()->year)->count());
  }

  public function allCount(): Attribute
  {
    return Attribute::get(fn () =>  $this->count());
  }
}
