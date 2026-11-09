<?php

namespace App\DataTables\Console;

use App\Models\ContainerScrap;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Repositories\Console\ContainerScrapRepository;
use Illuminate\Support\Facades\Auth;

class ContainerScrapDataTable extends DataTable
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
            ->addColumn('action', 'console.container-scrap.action')
            ->editColumn('created_at', function ($i) {
                return $i->created_at->format('d-m-Y H:i:s');
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/ContainerScrap $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContainerScrapRepository $repository)
    {
        return $repository->getDataTableQuery();
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

        if (Auth::user()->hasRole('Supervisor')) {
            array_unshift($buttons, Button::make('create'));
        }

        return $this->builder()
            ->setTableId('console-container-scrap-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('vendor.name')->title('Vendor'),
            Column::make('location.code')->title('Lokasi'),
            Column::make('status')->title('Status'),
            Column::make('created_by_user.name', 'createdByUser.name')->title('Dibuat Oleh'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
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
        return 'Console/ContainerScrap_' . date('YmdHis');
    }
}