<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditLogsController extends Controller
{
  public function index(Request $request)
  {

    if ($request->ajax()) {
      $model = AuditLog::query()->select(sprintf('%s.*', (new AuditLog())->getTable()));
      $table = Datatables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'audit-logs';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });

      $table->editColumn('id', fn ($row) => $row->id ? $row->id : '');
      $table->editColumn('description', fn ($row) => $row->description ? $row->description : '');
      $table->editColumn('subject_id', fn ($row) => $row->subject_id ? $row->subject_id : '');
      $table->editColumn('subject_type', fn ($row) => $row->subject_type ? $row->subject_type : '');
      $table->editColumn('user_id', fn ($row) => $row->user_id ? $row->user_id : '');
      $table->editColumn('host', fn ($row) => $row->host ? $row->host : '');

      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    return view('admin.audit-logs.index');
  }

  public function show(AuditLog $auditLog)
  {
    return view('admin.audit-logs.show', compact('auditLog'));
  }
}
