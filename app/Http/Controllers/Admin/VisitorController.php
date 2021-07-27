<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StatisticsDataTable;
use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    public function index(StatisticsDataTable $dataTable)
    {
        return $dataTable->render('admin.visitor', ['statistic' => new Statistic()]);
    }

    public function destroyAll(Request $request)
    {
        Statistic::truncate();

        event(new UserLogged($request->user(), 'Menghapus semua statistik pengunjung'));

        return back()->with('status', 'Semua statistik pengunjung berhasil dihapus');
    }
}
