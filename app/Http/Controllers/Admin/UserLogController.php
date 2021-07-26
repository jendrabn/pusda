<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserLogsDataTable;
use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function index(UserLogsDataTable $dataTable)
    {
        return $dataTable->render('admin.user_logs');
    }

    public function destroyAll()
    {
        UserLog::truncate();
        return back()->with('alert-success', 'Semua data berhasil dihapus');
    }
}
