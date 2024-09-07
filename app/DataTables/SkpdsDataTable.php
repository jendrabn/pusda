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
			->addColumn('action', 'admin.skpd.partials.action')
			->setRowId('id')
			->rawColumns(['action']);
	}

	/**
	 * Get the query source of dataTable.
	 */
	public function query(Skpd $model): QueryBuilder
	{
		return $model->newQuery()->with(['kategori'])->select('skpd.*');
	}

	/**
	 * Optional method if you want to use the html builder.
	 */
	public function html(): HtmlBuilder
	{
		return $this->builder()
			->setTableId('dataTable-skpd')
			->columns($this->getColumns())
			->minifiedAjax()
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
			Column::checkbox('&nbsp;')->printable(false)->exportable(false)->width(35),
			Column::make('id')->title('ID'),
			Column::make('kategori.nama', 'kategori.nama')->title('Kategori'),
			Column::make('nama'),
			Column::make('singkatan'),
			Column::make('created_at')->visible(false),
			Column::make('updated_at')->visible(false),
			Column::computed('action', '&nbsp;')->exportable(false)->printable(false)->addClass('text-center'),
		];
	}

	/**
	 * Get the filename for export.
	 */
	protected function filename(): string
	{
		return 'Skpds_' . date('dmY');
	}
}
