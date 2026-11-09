<?php

namespace App\Http\Livewire\ContainerDailyActivity;

use App\Models\ContainerDailyActivity;
use App\Models\ContainerDailyActivityDetail;
use Livewire\Component;

class TableDailyActivityDetail extends Component
{
    public $containerDailyActivity;

    protected $listeners = ['refresh-component' => '$refresh'];

    public function mount($containerDailyActivityId)
    {
        $this->containerDailyActivity = ContainerDailyActivity::find($containerDailyActivityId);
    }

    public function delete(ContainerDailyActivityDetail $containerDailyActivityDetail)
    {
        $containerDailyActivityDetail->delete();
        session()->flash('livewire_message', 'Berhasil menghapus detail laporan aktivitas harian');
        $this->emit('refresh-component');
    }

    public function render()
    {
        return view('livewire.container-daily-activity.table-daily-activity-detail');
    }
}
