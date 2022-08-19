<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;

class DashboardController extends Controller
{
    public function __invoke()
    {

        return view('admin.dashboard', [
            'total_8keldata' => Uraian8KelData::count(),
            'total_rpjmd' =>  UraianRpjmd::count(),
            'total_indikator' => UraianIndikator::count(),
            'total_bps' =>  UraianBps::count()
        ]);
    }
}
