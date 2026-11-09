<?php

namespace App\DataTables\Console;

use App\Enums\RoleEnum;
use App\Models\Contract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContractDataTable extends DataTable
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
            ->editColumn('created_by', function($q) {
                $created_by = $q->admin->name;
                return $created_by;
            })
            ->editColumn('active_date', function($q) {
                $active_date_start = date('d-m-Y', strtotime($q->active_date_start));
                $active_date_end = date('d-m-Y', strtotime($q->active_date_end));
                $active_date = '<small>' . $active_date_start . ' - ' . $active_date_end . '</small>';
                return $active_date;
            })
            // ->editColumn('warranty_date', function($q) {

            //     if($q->warranty_date_start == null && $q->warranty_date_end == null) {
            //         $warranty_date = '<small> - </small>';
            //     } else {

            //         $warranty_date_start = date('d-m-Y', strtotime($q->warranty_date_start));
            //         $warranty_date_end = date('d-m-Y', strtotime($q->warranty_date_end));
            //         $warranty_date = '<small>'  . $warranty_date_start . ' - ' . $warranty_date_end . '</small>';
                    
            //     }
            //     return $warranty_date;
            // })
            ->editColumn('vendor_id', function($q) {
                $vendor = $q->vendor->name;
                return $vendor;
            })
            // ->editColumn('warranty_in_month', function($q) {
            //     if($q->warranty_in_month == null || $q->warranty_in_month == 0) {
            //         $warranty_in_month = '<small> - </small>';
            //     } else {
            //         $warranty_in_month = $q->warranty_in_month . ' Bulan';
            //     }
            //     return $warranty_in_month;
            // })
            ->addColumn('action', 'console.master.contract.action')
            ->rawColumns(['action', 'active_date', 'warranty_date', 'warranty_in_month']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/ContractDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contract $model)
    {
        return $model->newQuery()->with(['vendor', 'createdByUser']);
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

        if (Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Supervisor')) {
            array_unshift($buttons, Button::make('create'));
        }

        return $this->builder()
                    ->setTableId('console-contract-table')
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
            Column::make('code')->title('No Kontrak'),
            Column::make('vendor.name', 'vendor.name')->title('Nama Vendor'),
            Column::make('subject')->title('Subject'),
            Column::make('type')->title('Tipe'),
            Column::make('status')->title('Status'),
            Column::make('active_date')->searchable(false)->orderable(false)->title('Masa berlaku'),
            Column::make('created_by_user.name', 'createdByUser.name')->title('Dibuat oleh'),
            // Column::make('warranty_date')->searchable(false)->orderable(false)->title('Masa garansi'),
            // Column::make('warranty_in_month')->searchable(false)->orderable(false)->title('Masa garansi (bulan)'),
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
        return 'Console/Contract_' . date('YmdHis');
    }
}
