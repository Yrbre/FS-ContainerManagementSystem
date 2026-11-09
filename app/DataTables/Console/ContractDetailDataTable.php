<?php

namespace App\DataTables\Console;

use App\Enums\RoleEnum;
use Psy\Command\EditCommand;
use App\Models\ContractDetail;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContractDetailDataTable extends DataTable
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
            ->editColumn('unit_id', function($q) {
                $unit = $q->unit->name;
                return $unit;
            })
            ->editColumn('price', function($q) {
                $price = 'Rp. ' . number_format($q->price, 0, ',', '.');
                return $price;
            })
            ->editColumn('working_duration', function($q) {
                if($q->working_duration == 0) {
                    $working_duration = 'Tidak di set';
                    return $working_duration;
                }
                $working_duration = $q->working_duration . ' Hari';
                return $working_duration;
            })
            ->addColumn('action', 'console.master.contract_detail.action')
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/ContractDetailDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContractDetail $model)
    {
        return $model->newQuery()->with(['unit', 'contract'])
                    ->select(
                        'contract_details.*',
                        'units.name as unit_name',
                    )
                    ->join('units', 'units.id', '=', 'contract_details.unit_id')
                    ->join('contracts', 'contracts.id', '=', 'contract_details.contract_id')
                    ->where('contracts.id', $this->contractId);
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
                    ->setTableId('console-cotract_detail-table')
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
            Column::make('job_type')->title('Jenis perbaikan'),
            Column::make('qty')->title('Kuantitas'),
            Column::make('unit_id', 'unit.name')->title('Satuan'),
            Column::make('price')->title('Harga'),
            Column::make('working_duration')->title('Durasi Pengerjaan'),
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
        return 'Console/ContractDetail_' . date('YmdHis');
    }
}
