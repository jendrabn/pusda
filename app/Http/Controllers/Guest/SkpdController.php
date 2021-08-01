<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;

class SkpdController extends Controller
{
    public function index()
    {
        $skpd = Skpd::where('id', '!=', 1)->orderBy('skpd_category_id', 'asc')->get();
        return view('guest.skpd', compact('skpd'));
    }

    public function delapankeldata($skpd_id)
    {
        $tabel8KelDataIds = Uraian8KelData::select('tabel_8keldata_id as id')
            ->where('skpd_id', $skpd_id)
            ->groupBy('tabel_8keldata_id')
            ->get();

        $categories = Tabel8KelData::where('parent_id', 1)->get();

        return view('guest.skpd_delapankeldata', compact('tabel8KelDataIds', 'categories'));
    }
}
