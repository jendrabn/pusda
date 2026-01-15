<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditLogController extends Controller
{
	/**
	 * Undocumented function
	 *
	 * @param Request $request
	 * @return JsonResponse|View
	 */
	public function index(Request $request): JsonResponse|View
	{
		if ($request->ajax()) {
			$model = AuditLog::select(sprintf('%s.*', (new AuditLog())->getTable()));
			$table = Datatables::eloquent($model);

			$table->addColumn('placeholder', '&nbsp;');
			$table->addColumn('actions', '&nbsp;');

			$table->editColumn('actions', function ($row) {
				$crudRoutePart = 'audit-logs';

				// Check if routes exist (similar to the partial logic)
				$viewBtn = '';
				$editBtn = '';
				$deleteBtn = '';

				// Check if show route exists
				if (\Illuminate\Support\Facades\Route::has('admin.' . $crudRoutePart . '.show')) {
					$viewBtn = '<a class="btn btn-sm btn-primary" href="' . route('admin.' . $crudRoutePart . '.show', $row->id) . '" title="View"><i class="fas fa-eye"></i></a>';
				}

				// Check if edit route exists (for audit logs it doesn't based on routes)
				if (\Illuminate\Support\Facades\Route::has('admin.' . $crudRoutePart . '.edit')) {
					$editBtn = '<a class="btn btn-sm btn-warning" href="' . route('admin.' . $crudRoutePart . '.edit', $row->id) . '" title="Edit"><i class="fas fa-pencil-alt"></i></a>';
				}

				// Check if destroy route exists
				if (\Illuminate\Support\Facades\Route::has('admin.' . $crudRoutePart . '.destroy')) {
					$deleteBtn = '<form action="' . route('admin.' . $crudRoutePart . '.destroy', $row->id) . '" class="m-0 p-0" method="POST" onsubmit="return confirm(\'Are you sure?\');">' .
						'<input type="hidden" name="_token" value="' . csrf_token() . '">' .
						'<input type="hidden" name="_method" value="DELETE">' .
						'<button class="btn btn-sm btn-danger" title="Delete" type="submit"><i class="fas fa-trash-alt"></i></button>' .
						'</form>';
				}

				return '<div class="action-buttons">' . $viewBtn . $editBtn . $deleteBtn . '</div>';
			});

			$table->editColumn('id', fn($row) => $row->id ? $row->id : '');
			$table->editColumn('description', fn($row) => $row->description ? $row->description : '');
			$table->editColumn('subject_id', fn($row) => $row->subject_id ? $row->subject_id : '');
			$table->editColumn('subject_type', fn($row) => $row->subject_type ? $row->subject_type : '');
			$table->editColumn('user_id', fn($row) => $row->user_id ? $row->user_id : '');
			$table->editColumn('host', fn($row) => $row->host ? $row->host : '');

			$table->rawColumns(['actions', 'placeholder']);

			return $table->toJson();
		}

		return view('admin.audit-logs.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param AuditLog $auditLog
	 * @return View
	 */
	public function show(AuditLog $auditLog): View
	{
		return view('admin.audit-logs.show', compact('auditLog'));
	}

	/**
	 * Mass delete selected audit logs
	 *
	 * @param Request $request
	 * @return void
	 */
	public function massDestroy(Request $request)
	{
		$request->validate([
			'ids' => ['required', 'array'],
			'ids.*' => ['required', 'exists:audit_logs,id'],
		]);

		AuditLog::whereIn('id', $request->ids)->delete();

		return response(null, 204);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param AuditLog $auditLog
	 * @return void
	 */
	public function destroy(AuditLog $auditLog)
	{
		$auditLog->delete();

		return redirect()->route('admin.audit-logs.index');
	}
}
