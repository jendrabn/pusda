<?php

namespace App\DataTables;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AuditLogsDataTable extends DataTable
{
	/**
	 * Build the DataTable class.
	 *
	 * @param QueryBuilder $query Results from query() method.
	 */
	public function dataTable(QueryBuilder $query): EloquentDataTable
	{
		return (new EloquentDataTable($query))
			->addColumn('action', function ($row) {
				return sprintf('<a class="btn btn-xs btn-primary" href="%s">%s</a>', route('admin.audit-logs.show', $row->id), 'View');
			})
			->editColumn('user_id', function ($row): string {
				return $row->user_id
					? sprintf('<a href="%s" target="_blank">%s</a>', route('admin.users.edit', $row->user_id), $row->user_id)
					: '';
			})
			->setRowId('id')
			->rawColumns(['action', 'user_id']);
	}

	/**
	 * Get the query source of dataTable.
	 */
	public function query(AuditLog $model): QueryBuilder
	{
		return $model->newQuery();
	}

	/**
	 * Optional method if you want to use the html builder.
	 */
	public function html(): HtmlBuilder
	{
		return $this->builder()
			->setTableId('auditlogs-table')
			->columns($this->getColumns())
			->minifiedAjax()
			->orderBy(0, 'desc')
			->buttons([
				Button::make([
					'extend' => 'excel',
					'text' => 'Excel',
					'className' => 'btn-secondary',
				]),
				Button::make([
					'extend' => 'colvis',
					'text' => 'Columns',
					'className' => 'btn-secondary',
				]),
			]);
	}

	/**
	 * Get the dataTable columns definition.
	 */
	public function getColumns(): array
	{
		return [
			Column::make('id')->title('ID'),
			Column::make('description'),
			Column::make('subject_id')->title('Subject ID'),
			Column::make('subject_type'),
			Column::make('user_id')->title('User ID'),
			Column::make('host'),
			Column::make('created_at'),
			Column::computed('action', '&nbsp;')->exportable(false),
		];
	}

	/**
	 * Get the filename for export.
	 */
	protected function filename(): string
	{
		return 'AuditLogs_' . date('Ymd');
	}
}
