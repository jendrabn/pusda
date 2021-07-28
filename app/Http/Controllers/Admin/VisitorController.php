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
        abort_if(!$request->ajax(), 404);

        Statistic::truncate();

        event(new UserLogged($request->user(), 'Menghapus semua statistik pengunjung'));

        return response()->json([
            'success' => true,
            'message' => 'Semua statistik pengunjung berhasil dihapus'
        ], 200);
    }
}
