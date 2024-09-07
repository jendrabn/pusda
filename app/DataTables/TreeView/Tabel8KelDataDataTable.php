<?php

namespace App\DataTables\TreeView;

use App\Models\Tabel8KelData;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class Tabel8KelDataDataTable extends DataTable
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
				$routePart = 'delapankeldata';

				return view('admin.treeview.partials.action', compact('row', 'routePart'));
			})
			->setRowId('id');
	}

	/**
	 * Get the query source of dataTable.
	 */
	public function query(Tabel8KelData $model): QueryBuilder
	{
		return $model->newQuery()->with(['parent', 'skpd'])->select('tabel_8keldata.*');
	}

	/**
	 * Optional method if you want to use the html builder.
	 */
	public function html(): HtmlBuilder
	{
		return $this->builder()
			->setTableId('dataTable-MenuTreeView')
			->columns($this->getColumns())
			->minifiedAjax(route('admin.treeview.delapankeldata.index'))
			//->dom('Bfrtip')
			->orderBy(1, 'asc')
			->pageLength(25)
			->selectStyleMultiShift()
			->selectSelector('td:first-child')
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
			Column::checkbox('&nbsp;')->exportable(false)->printable(false)->width(35),
			Column::make('id')->title('ID'),
			Column::make('skpd.nama', 'skpd.nama')->title('SKPD'),
			Column::make('parent_id', 'parent_id')->title('Parent ID')->visible(false),
			Column::make('parent.nama_menu', 'parent.nama_menu')->title('Parent'),
			Column::make('nama_menu'),
			Column::make('created_at')->visible(false),
			Column::make('updated_at')->visible(false),
			Column::computed('action')->exportable(false)->printable(false)->addClass('text-center'),
		];
	}

	/**
	 * Get the filename for export.
	 */
	protected function filename(): string
	{
		return 'Tabel8KelData_' . date('dmyHis');
	}
}
