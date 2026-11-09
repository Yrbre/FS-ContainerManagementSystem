<?php

namespace App\DataTables\Console;

use App\Enums\RoleEnum;
use App\Models\Admin;
use App\Models\ContainerDelegation;
use App\Models\ContainerDelegationFromVendor;
use App\Repositories\Console\ContainerDelegationFromVendorRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DelegationFromVendorDataTable extends DataTable
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
            ->addColumn('action', 'console.container-delegation-from-vendor.action')
            ->editColumn('created_at', function($i){
                return $i->created_at->format('d-m-Y H:i:s');
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/ContainerDelegation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContainerDelegationFromVendorRepository $repository)
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

        if (Auth::user()->hasRole('Checker')) {
            array_unshift($buttons, Button::make('create'));
        }
        
        return $this->builder()
            ->setTableId('console-delegation-from-vendor-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(2)
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
            Column::make('job_type')->title('Tipe Transaksi'),
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
        return 'Console/DelegationFromVendor_' . date('YmdHis');
    }
}
