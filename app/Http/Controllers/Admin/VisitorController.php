<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StatisticsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Statistic;


class VisitorController extends Controller
{

    public function index(StatisticsDataTable $dataTable)
    {
        return $dataTable->render('admin.visitor', ['statistic' => new Statistic()]);
    }

    public function destroyAll()
    {
        Statistic::truncate();
        return back()->with('status', 'Semua log user login berhasil dihapus');
    }
}
