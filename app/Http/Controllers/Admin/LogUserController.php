<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;


class LogUserController extends Controller
{
    public function index()
    {
        $userLogs = UserLog::latest()->get();
        if (request()->ajax()) {
            return datatables()->of($userLogs)
                ->addColumn('name', function ($s) {
                    return $s->user->name . ' ' . $s->user->role;
                })
                ->addColumn('SKPD', function ($s) {
                    return $s->user->skpd->singkatan;
                })
                ->addColumn('aksi', function ($s) {
                    $button = " <button class='btn btn-icon btn-sm btn-danger m-1 btn-delete' id='" . $s->id . "'><i class='fas fa-trash-alt'></i>
                  </button>";
                    return $button;
                })
                ->rawColumns(['name', 'SKPD', 'aksi'])
                ->toJson();
        }
        return view('admin.log-user', compact('userLogs'));
    }

    public function destroy($id)
    {

        UserLog::find($id)->delete();
        return response()->json(['success' => 'berhasil dhiapu  s']);
    }

    public function destroyAll()
    {
        UserLog::truncate();
        return back()->with('alert-success', 'Semua data berhasil dihapus');
    }
}
