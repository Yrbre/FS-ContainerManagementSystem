<?php

namespace App\DataTables;

use App\Models\ContainerRepair;
use App\Repositories\Console\ContainerRepairRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContainerRepairDataTable extends DataTable
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
            ->editColumn('created_at', function($i){
                return $i->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('action', 'console.container-repair.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ContainerRepairDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContainerRepairRepository $repository)
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

        // Permission Check
        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Checker')) {
            array_unshift($buttons, Button::make('create'));
        }

        return $this->builder()
            ->setTableId('console-container_repair-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(4)
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
            Column::make('vendor.name', 'vendor.name')->title('Nama Vendor'),
            Column::make('location.code')->title('Lokasi'),
            Column::make('created_at')->searchable()->title('Tgl. Perbaikan'),
            Column::make('status')->title('Status'),
            Column::make('created_by_user.name', 'createdByUser.name')->title('Dibuat Oleh'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
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
        return 'ContainerRepair_' . date('YmdHis');
    }
}
