<?php

namespace App\Http\Livewire\ContainerRepair;

use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class ContainerRepairProgress extends Component
{   

    public $containerRepair;
    public $detailIds = [];
    public $progress = [];
    public $description = [];
    public $groupData = [];
    public $data;
    public $updatesModal = '';
    public $inputProgressed;
    public $inputDescriptions;
    public $passed = [];
    public $groupBulkData = [];
    public $bulkErrors = [];

    public function mount($containerRepair)
    {
        $this->containerRepair = $containerRepair;
        $this->progress = $this->containerRepair->details()->pluck('progress', 'id')->toArray();
        $this->description = $this->containerRepair->details()->pluck('description', 'id')->toArray();
        
    }

    public function updatedDetailIds()
    {
        // insert value detailIds to groupData as id
        foreach($this->detailIds as $key => $id) {
            // change key index to id
            $this->groupData[$id] = [
                'id' => $id,
            ];

            $this->groupBulkData[$id] = [
                'id' => $id,
            ];
        }

    }

    public function getDetailById($id) {
        return $this->containerRepair->details()->where('id', $id)->first();
    }

    // section if updates many active

    public function triggerShowModal() {
        $this->updatesModal = true;
    }

    public function updatedInputProgressed() {
        $progress = $this->inputProgressed;
        foreach($this->groupBulkData as $key => $group) {
           
            $this->groupBulkData[$group['id']]['progress'] = $progress;
            
        }
    }

    public function updatedInputDescriptions() {
        $description = $this->inputDescriptions;
        foreach($this->groupBulkData as $key => $group) {
            $this->groupBulkData[$group['id']]['description'] = $description;
        }
    }

    // endsections

    public function updatedProgress()
    {
    
        // insert value progress to groupData as progress
        foreach($this->progress as $id => $progress) {
            $this->groupData[$id]['progress'] = $progress;
        }

    }

    public function updatedDescription() {
        // insert value description to groupData as description
        foreach($this->description as $id => $description) {
            $this->groupData[$id]['description'] = $description;
        }
    }


    public function submit() {

        
        $this->validate([
            'progress.*' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                function($attribute, $value, $fail) {
                    // explode attribute to get id
                    $id = explode('.', $attribute)[1];
                    $detail = $this->getDetailById($id);
                    if($value < $detail->progress) {
                        $fail('Progress tidak boleh lebih kecil dari progress sebelumnya.');
                    }                    
                }
            ],
        ]);

            
        foreach($this->groupData as $key => $data) {
            try {
                $detail = $this->getDetailById($data['id']);
                $detail->update($data);
                session()->flash('message', 'Progress berhasil di update.');

            } catch (\Throwable $th) {
                session()->flash('message', $th->getMessage());

            }
         
        }         


        

    }


    public function submitProgressed() { 

        $passed = [];
        foreach($this->groupBulkData as $key => $data) {
            $id = $data['id'];

            if(isset($data['progress'])) {

                if(!is_numeric($data['progress'])) {
                    session()->flash('message_modal', 'Harus berupa angka.');
                    $this->bulkErrors[] = [
                        'id' => $id,
                        'value' => 'Harus berupa angka.',
                    ];
                    break;
                } 

                if($data['progress'] < $this->getDetailById($id)->progress) {
                        session()->flash('message_modal', 'Progress harus lebih besar dari progress sebelumnya. ');
                        $this->bulkErrors[] = [
                            'id' => $id,
                            'value' => 'Progress harus lebih besar dari progress sebelumnya. ',
                        ];
                        break;
                  
                }

                if($data['progress'] < 0) {
                    session()->flash('message_modal', 'Angka minimal harus 0');
                    $this->bulkErrors[] = [
                        'id' => $id,
                        'value' => 'Angka minimal harus 0',
                    ];
                    break;
                
                }

                if($data['progress'] > 100) {
                        session()->flash('message_modal', 'Angka maksimal harus 100');
                        $this->bulkErrors[] = [
                            'id' => $id,
                            'value' => 'Angka maksimal harus 100',
                        ];
                        break;
                }

                $passed[] = $key;
                
            } else {   
                session()->flash('message_modal', 'Isi terlebih dahulu.');
                $this->bulkErrors[] = [
                    'id' => null,
                    'value' => 'Isi terlebih dahulu.',
                ];

                break;
            }

        }

        $updated = [];

        
        if(count($this->bulkErrors) == 0) {
            foreach($this->groupBulkData as $key => $data) {

                if(in_array($data['id'], array_unique($passed))) {
                    
                    $detail = $this->getDetailById($data['id']);
                    $detail->update($data);
                    $updated[] = $key;


                } 
                
            }      

            session()->flash('success', 'Progress berhasil di update.');
            return redirect()->route('console.container-repair.detail', $this->containerRepair->id);
        }else {
            foreach($this->bulkErrors as $error) {
                    session()->flash('message_modal', $error['value']);
                    $this->bulkErrors = [];
                    break;
            }
        }

       


    }




    
   
    public function render()
    {
        return view('livewire.container-repair.container-repair-progress');
    }
}
