<?php

namespace App\Http\Livewire\Report\ContainerRecord;

use Livewire\Component;
use App\Models\Record;
use App\Models\Container;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class TableSection extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $container;


    public function export() {

        $filter = [
            'container' => $this->container,
        ];

        // return Excel::download(new CTReport($filter), 'ctc_report.xlsx');
    }


    public function render()
    {

        $containers = Container::all();

        if ($this->container) {
            $records = Record::with('container_code');
    
            $records->when($this->container, function($query, $container) {
                return $query->where('container_code', $container);
            });
        
            $records = $records->orderBy('action_date', 'DESC')
                ->paginate(10);
        } else {
            $records = new Collection();
        }

        return view('livewire.report.container-record.table-section', compact('containers', 'records'));
    }
}
