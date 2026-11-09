<?php

namespace App\DataTables\Console;

use App\Enums\RoleEnum;
use App\Models\Vendor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorDataTable extends DataTable
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
            ->addColumn('action', 'console.master.vendor.action')
            ->editColumn('address_2', function($q) {
                // make a badge when data its null
                if ($q->address_2 == null) {
                    return '<span class="badge badge-info">Belum di set</span>';
                } else {
                    return $q->address_2;
                }
            })
            ->editColumn('address_3', function($q) {
                // make a badge when data its null
                if ($q->address_3 == null) {
                    return '<span class="badge badge-info">Belum di set</span>';
                } else {
                    return $q->address_3;
                }
            })
            ->rawColumns(['action', 'address_2', 'address_3']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/VendorDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vendor $model)
    {
        return $model->newQuery()
                     ->with(['createdByUser'])
                     ->select('vendors.*');
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

        if (Auth::user()->hasRole('Administrator')) {
            array_unshift($buttons, Button::make('create'));
        }

        return $this->builder()
                    ->setTableId('console-vendor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::make('erp_code')->title('Kode ERP'),
            Column::make('name')->title('Nama vendor'),
            Column::make('address_1')->title('Alamat 1'),
            Column::make('address_2')->title('Alamat 2'),
            Column::make('address_3')->title('Alamat 3'),
            Column::make('created_by_user.name', 'createdByUser.name')->title('Dibuat oleh'),
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
        return 'Console/Vendor_' . date('YmdHis');
    }
}
