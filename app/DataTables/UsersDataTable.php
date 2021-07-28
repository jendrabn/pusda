<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', 'admin.user.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->with(['skpd']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
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
            Column::computed('DT_RowIndex', '#')->addClass('align-middle'),
            Column::make('skpd')
                ->data('skpd.singkatan')
                ->name('skpd.singkatan')
                ->title('SKPD')
                ->orderable(false)
                ->addClass('align-middle'),
            Column::make('name')
                ->title('Nama Lengkap')
                ->addClass('align-middle font-weight-bold'),
            Column::make('username')->addClass('align-middle'),
            Column::make('email')->addClass('align-middle'),
            Column::make('role')
                ->title('Level')
                ->searchable(false)
                ->orderable(false)
                ->addClass('align-middle'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center align-middle')
                ->title('Aksi'),
            Column::make('created_at')->hidden()
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
