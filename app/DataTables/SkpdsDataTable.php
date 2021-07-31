<?php

namespace App\DataTables;

use App\Models\Skpd;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SkpdsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($skpd) {
                return view('admin.skpd.action', compact('skpd'));
            })
            ->addColumn('skpd_category', function ($skpd) {
                return  $skpd->skpdCategory->name ?? '';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Skpd $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Skpd $model)
    {
        return $model->newQuery()->with('skpdCategory');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->parameters([
                'language' => [
                    'url' => url('https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json')
                ],
            ])
            ->setTableId('skpds-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', '#'),
            Column::make('nama'),
            Column::make('singkatan'),
            Column::make('skpd_category')->orderable(false)->searchable(false)->title('Kategori'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Skpds_' . date('YmdHis');
    }
}
