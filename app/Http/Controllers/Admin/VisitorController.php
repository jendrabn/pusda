<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Statistic;


class VisitorController extends Controller
{

    public function index(Request $request)
    {
        $visitors = Statistic::latest()->get();
        $statistic = new Statistic();
        return view('admin.visitor', compact('visitors', 'statistic'));
    }

    public function destroy(Statistic $visitor)
    {
        $visitor->delete();
        return back()->with('status', 'Data Pengunjung berhasil dihapus');
    }

    public function destroyAll()
    {
        Statistic::truncate();
        return back()->with('status', 'Semua log user login berhasil dihapus');
    }
}
