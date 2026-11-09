<?php

namespace App\DataTables\Console;

use App\Enums\RoleEnum;
use App\Models\Location;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LocationDataTable extends DataTable
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
            ->addColumn('action', 'console.master.location.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/LocationDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Location $model)
    {
        return $model->newQuery()
                    ->with('createdByUser')
                    ->select('locations.*');


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
                    ->setTableId('console-location-table')
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
            Column::make('code')->title('Kode lokasi'),
            Column::make('name')->title('Nama alamat'),
            Column::make('address')->title('Alamat'),
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
        return 'Console/Location_' . date('YmdHis');
    }
}
