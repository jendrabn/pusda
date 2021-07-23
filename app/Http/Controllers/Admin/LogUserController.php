<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLog;

class LogUserController extends Controller
{
    public function index()
    {
        $userLogs = UserLog::latest()->get();
        return view('admin.log-user', compact('userLogs'));
    }

    public function destroy(UserLog $userLog)
    {
        $userLog->delete();
        return back()->with('alert-success', 'Data berhasil dihapus');
    }

    public function destroyAll()
    {
        UserLog::truncate();
        return back()->with('alert-success', 'Semua data berhasil dihapus');
    }
}
