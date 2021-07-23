<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\Tabel8KelData;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $statistic = new Statistic();
        return view('guest.home', compact('statistic'));
    }
}
