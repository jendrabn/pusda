<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserLogsDataTable;
use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function index(UserLogsDataTable $dataTable)
    {
        return $dataTable->render('admin.user_logs');
    }

    public function destroyAll(Request $request)
    {
        UserLog::truncate();

        event(new UserLogged($request->user(), 'Menghapus semua log users'));

        return back()->with('alert-success', 'Semua log users berhasil dihapus');
    }
}
