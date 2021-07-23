<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $count8KelData = Uraian8KelData::all()->count();
        $countRpjmd = UraianRpjmd::all()->count();
        $countIndikator = UraianIndikator::all()->count();
        $countBps = UraianBps::all()->count();

        return view('admin.dashboard', compact('count8KelData', 'countRpjmd', 'countIndikator', 'countBps'));
    }
}
