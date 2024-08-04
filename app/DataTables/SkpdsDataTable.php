<?php

namespace App\DataTables;

use App\Models\Skpd;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SkpdsDataTable extends DataTable
{
	/**
	 * Build the DataTable class.
	 *
	 * @param QueryBuilder $query Results from query() method.
	 */
	public function dataTable(QueryBuilder $query): EloquentDataTable
	{
		return (new EloquentDataTable($query))
			->addColumn('action', 'admin.skpd.action')
			->setRowId('id')
			->rawColumns(['action']);
	}

	/**
	 * Get the query source of dataTable.
	 */
	public function query(Skpd $model): QueryBuilder
	{
		return $model->newQuery()->with(['kategori'])->select($model->getTable() . '.*');
	}

	/**
	 * Optional method if you want to use the html builder.
	 */
	public function html(): HtmlBuilder
	{
		return $this->builder()
			->setTableId('skpd-table')
			->columns($this->getColumns())
			->minifiedAjax()
			->selectStyleMultiShift()
			->selectSelector('td:first-child')
			->buttons([
				Button::make([
					'extend' => 'create',
					'text' => 'Create',
					'className' => 'btn-success',
				]),
				Button::make([
					'extend' => 'selectAll',
					'text' => 'Select all',
					'className' => 'btn-primary',
				]),
				Button::make([
					'extend' => 'selectNone',
					'text' => 'Deselect all',
					'className' => 'btn-primary',
				]),
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
				Button::make([
					'extend' => 'deleteSelected',
					'text' => 'Delete Selected',
					'className' => 'btn-danger',
				]),
			]);
	}

	/**
	 * Get the dataTable columns definition.
	 */
	public function getColumns(): array
	{
		return [
			Column::checkbox('&nbsp;')->width(25),
			Column::make('id')->title('ID'),
			Column::make('kategori.nama', 'kategori.nama')->title('Kategori'),
			Column::make('nama'),
			Column::make('singkatan'),
			Column::make('created_at'),
			Column::computed('action', '&nbsp;')->exportable(false)->printable(false)
		];
	}

	/**
	 * Get the filename for export.
	 */
	protected function filename(): string
	{
		return 'Skpds_' . date('YmdHis');
	}
}
