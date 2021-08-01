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
        abort_if(!$request->ajax(), 404);

        UserLog::truncate();
        save_user_log('Menghapus semua user logs');

        return response()->json([
            'success' => true,
            'message' => 'Semua user logs berhasil dihapus'
        ], 200);
    }
}
