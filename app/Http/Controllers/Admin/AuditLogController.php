<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AuditLogsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class AuditLogController extends Controller
{

	/**
	 * Render the index view for the AuditLogsDataTable.
	 *
	 * @param AuditLogsDataTable $dataTable
	 * @return JsonResponse|View|BinaryFileResponse
	 */
	public function index(AuditLogsDataTable $dataTable): JsonResponse|View|BinaryFileResponse
	{
		return $dataTable->render('admin.auditLogs.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param AuditLog $auditLog
	 * @return View
	 */
	public function show(AuditLog $auditLog): View
	{
		return view('admin.auditLogs.show', compact('auditLog'));
	}
}
