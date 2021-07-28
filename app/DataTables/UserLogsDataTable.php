<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserLogsDataTable extends DataTable
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
            ->editColumn('created_at', function ($log) {
                return $log->created_at ? with(new Carbon($log->created_at))->diffForHumans() : '';
            })
            ->addIndexColumn()
            ->rawColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UserLog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserLog $model)
    {
        return $model->newQuery()->with(['user']);
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
            ->setTableId('userlogs-table')
            ->columns($this->getColumns())
            ->languageEmptyTable('Data user logs belum tersedia')
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
            Column::make('name')
                ->data('user.name')
                ->name('user.name')
                ->orderable(false)
                ->title('Nama Lengkap')
                ->addClass('font-weight-bold'),
            Column::make('name')
                ->data('user.username')
                ->name('user.username')
                ->title('Username')
                ->orderable(false),
            Column::make('user')
                ->data('user.role')
                ->title('Level')
                ->orderable(false)
                ->searchable(false),
            Column::make('type')->title('Tipe'),
            Column::make('created_at')
                ->title('Waktu')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'UserLogs_' . date('YmdHis');
    }
}
