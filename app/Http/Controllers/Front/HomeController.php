<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Statistic;

class HomeController extends Controller
{
    public function __invoke()
    {
        $statistic = new Statistic();

        return view('front.home', compact('statistic'));
    }
}
