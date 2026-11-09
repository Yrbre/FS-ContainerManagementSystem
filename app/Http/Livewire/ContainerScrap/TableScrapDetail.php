<?php

namespace App\Http\Livewire\ContainerScrap;

use App\Models\ContainerScrap;
use App\Models\ContainerScrapDetail;
use Livewire\Component;

class TableScrapDetail extends Component
{
    public $containerScrap;

    protected $listeners = ['refresh-component' => '$refresh'];

    public function mount($containerScrapId)
    {
        $this->containerScrap = ContainerScrap::find($containerScrapId);
    }

    public function delete(ContainerScrapDetail $containerScrapDetail)
    {
        $containerScrapDetail->delete();
        session()->flash('livewire_message', 'Berhasil menghapus detail scrap container');
        $this->emit('refresh-component');
    }
    public function render()
    {
        return view('livewire.container-scrap.table-scrap-detail');
    }
}