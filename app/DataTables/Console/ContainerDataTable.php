<?php

namespace App\DataTables\Console;

use App\Enums\RoleEnum;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Container;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Repositories\Console\ContainerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContainerDataTable extends DataTable
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
            ->orderColumn('code', function($query, $order){
                $query->orderBy(DB::raw('TRY_CAST(code as INT)'), $order);
            })
            ->addColumn('action', 'console.master.container.action')
            ->editColumn('buy_date', function ($q) {
                if ($q->buy_date != null) {
                    return Carbon::parse($q->buy_date)->format('d-m-Y');
                } else {
                    return '-';
                }
            })
            ->editColumn('last_upgrade_date', function ($q) {
                if ($q->last_upgrade_date) {
                    return Carbon::parse($q->last_upgrade_date)->format('d-m-Y');
                } else {
                    return '';
                }
            })
            ->editColumn('last_maintenance_date', function ($q) {
                if ($q->last_maintenance_date) {
                    return Carbon::parse($q->last_maintenance_date)->format('d-m-Y');
                } else {
                    return '-';
                }
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/Container $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContainerRepository $containerRepository)
    {
        return $containerRepository->dataTableQuery();
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
            ->setTableId('console-container-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
            // Column::computed('DT_RowIndex')->title('#'),
            Column::make('code')->title('Nomor CT'),
            Column::make('vendor.name')->title('Vendor Pembelian'),
            Column::make('buy_date')->title('Tgl. Pembelian'),
            Column::make('last_upgrade_vendor.name', 'vendor.name')->title('Vendor Upgrade Terakhir'),
            Column::make('last_upgrade_date')->title('Tgl. Upgrade Terakhir'),
            Column::make('last_maintenance_vendor.name', 'vendor.name')->title('Vendor Maintenance Terakhir'),
            Column::make('last_maintenance_date')->title('Tgl. Maintenance Terakhir'),
            Column::make('company.name')->title('Company'),
            Column::make('status.code')->title('Status Terakhir'),
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
        return 'Console/Container_' . date('YmdHis');
    }
}
