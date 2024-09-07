<?php

namespace App\DataTables\Uraian;

use App\Models\UraianBps;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UraianBpsDataTable extends DataTable
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
				$routePart = 'bps';

				return view('admin.uraian.partials.action', compact('row', 'routePart'));
			})
			->editColumn('uraian_label', function ($row) {
				return $row->parent_id
					? '<span style="text-indent: 1.5rem; display: block">' . $row->uraian . '</span>'
					: '<span style="font-weight: bold">' . $row->uraian . '</span>';
			})
			->setRowId('id')
			->rawColumns(['uraian_label']);
	}

	/**
	 * Get the query source of dataTable.
	 */
	public function query(UraianBps $model): QueryBuilder
	{
		return $model
			->newQuery()
			->with('parent')
			->select('uraian_bps.*')
			->from('uraian_bps')
			->leftJoin('uraian_bps as b', 'uraian_bps.id', '=', 'b.parent_id')
			->where('uraian_bps.tabel_bps_id', request('tabel')->id)
			->orderByRaw('CASE WHEN uraian_bps.parent_id IS NULL THEN uraian_bps.id ELSE uraian_bps.parent_id END')
			->orderBy('uraian_bps.parent_id')
			->orderBy('uraian_bps.id')
			->distinct();
	}

	/**
	 * Optional method if you want to use the html builder.
	 */
	public function html(): HtmlBuilder
	{
		return $this->builder()
			->setTableId('dataTable-Uraian')
			->columns($this->getColumns())
			->minifiedAjax()
			//->dom('Bfrtip')
			->orderBy(1)
			->selectStyleMultiShift()
			->selectSelector('td:first-child')
			->pageLength(25)
			->buttons([
				Button::make('create'),
				Button::make('selectAll'),
				Button::make('selectNone'),
				Button::make('excel'),
				Button::make('reset'),
				Button::make('reload'),
				Button::make('colvis'),
				Button::make('bulkDelete'),
			]);
	}

	/**
	 * Get the dataTable columns definition.
	 */
	public function getColumns(): array
	{
		return [
			Column::checkbox('&nbsp;')->orderable(false)->searchable(false)->width(35),
			Column::make('id', 'uraian_bps.id')->title('ID')->orderable(false),
			Column::make('parent_id', 'uraian_bps.parent_id')->title('Parent ID')->orderable(false)->visible(false),
			Column::make('parent.uraian', 'parent.uraian')->title('Parent')->orderable(false)->visible(false),
			Column::make('uraian_label', 'uraian_bps.uraian')->title('Uraian')->orderable(false),
			Column::make('created_at', 'uraian_bps.created_at')->orderable(false)->visible(false),
			Column::make('updated_at', 'uraian_bps.updated_at')->orderable(false)->visible(false),
			Column::computed('action', '&nbsp;')->exportable(false)->printable(false)->addClass('text-center'),
		];
	}

	/**
	 * Get the filename for export.
	 */
	protected function filename(): string
	{
		return 'UraianBps_' . date('dmY');
	}
}
