<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Finance;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;

class Collection extends Component
{
    protected $listeners = [
        'balanceReload' => 'processBalance',
    ];
    public $assignment;
    public $showFollowUp=true;
    public $showLien=true;
    public $showProjectedLien=true;
    public $follow_up_date;
    public $lien_date_m;
    public $lien_info;
    public $projected_lien_date;
    public $projected_lien_active;

    public function mount(AssignmentFinanceRepository $assignment)
    {
        $this->assignment = $assignment;
        $this->follow_up_date = $this->assignment->follow_up;
        $this->lien_date_m = $this->assignment->lien_date;
        $this->lien_info = $this->assignment->lien_info;
        $this->projected_lien_date = $this->assignment->projected_lien_date;
        $this->projected_lien_active = $this->assignment->projected_lien_active;
    }
    public function updateFollowup($formData){

        $this->assignment->update($formData);
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

        $this->toggleFollowup();
    }
    public function setCollectionStatus($id){
        $update['status_collection_id']=$id;
        $this->assignment->update($update);
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
    }

    public function updateLien($formData){

        $formData['status_id']=9;
        $formData['status_collection_id']=9;
        $this->assignment->update($formData);
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
        $this->toggleLien();

        $this->emit('updateScheduling');
    }

    public function updateProjectedLien($formData){

        $this->assignment->update($formData);
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

        $this->toggleProjectedLien();
    }

    public function toggleLien(){
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
        $this->showLien=!$this->showLien;

        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
    }
    public function toggleFollowup(){

        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
        $this->showFollowUp=!$this->showFollowUp;

        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

    }
    public function toggleProjectedLien(){
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
        $this->showProjectedLien=!$this->showProjectedLien;

        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);
    }

    public function toggleProjectedLienActive()
    {
        // Alterna entre 'Y' e 'N'
        $this->projected_lien_active = $this->projected_lien_active === 'Y' ? 'N' : 'Y';

        // Atualiza no banco de dados
        $this->assignment->update([
            'projected_lien_active' => $this->projected_lien_active
        ]);
    }
    
    public function processBalance(){
        $this->assignment = AssignmentFinanceRepository::find($this->assignment->id);

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.finance.collection');
    }
}