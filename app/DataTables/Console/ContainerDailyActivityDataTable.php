<?php

namespace App\DataTables\Console;

use App\Models\ContainerDailyActivity;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContainerDailyActivityDataTable extends DataTable
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
            ->addColumn('action', 'console.container-daily-activity.action')
            ->editColumn('created_at', function ($i) {
                return $i->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('created_by_user.name', function ($i) {
                return $i->createdByUser->name ?? '';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/inspectionDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContainerDailyActivity $model)
    {
        return $model->newQuery()->with(['location', 'createdByUser'])->select('container_daily_activities.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [
            Button::make('reset'),
            Button::make('reload')
        ];

        // Permission Check
        if (Auth::user()->hasRole('Checker')) {
            array_unshift($buttons, Button::make('create'));
        }
        return $this->builder()
            ->setTableId('console-container-daily-activity-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(2) //change this line to configure sorting
            ->buttons(
                $buttons
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')->title('#'),
            Column::make('code')->title('No. Transaksi'),
            Column::make('created_at')->title('Tgl. Dibuat'),
            Column::make('location.code')->title('Lokasi'),
            Column::make('status')->title('Status'),
            Column::make('created_by_user.name', 'createdByUser.name')->title('Dibuat oleh'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Console/container-daily-activity_' . date('YmdHis');
    }
}