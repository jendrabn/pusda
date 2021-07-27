<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;
use App\Models\UserLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {

        $info = [
            'total_8keldata' => Uraian8KelData::count(),
            'total_rpjmd' =>  UraianRpjmd::count(),
            'total_indikator' => UraianIndikator::count(),
            'total_bps' =>  UraianBps::count()
        ];

        $userLogs = UserLog::limit(5)->latest()->get();
        
        return view('admin.dashboard', compact('info', 'userLogs'));
    }
}
