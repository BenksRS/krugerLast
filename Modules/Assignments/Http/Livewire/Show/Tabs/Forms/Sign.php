<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Forms;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Signdata;

class Sign extends Component
{
    protected $listeners = [
        'selectSign' => 'processPreferred'
    ];

    public $assignment;
    public $signs;

    public function mount(Assignment $assignment)
    {

        $this->assignment = $assignment;
        $this->signs = $this->assignment->signs;
    }

    public function processPreferred($id){

//        dd($id);
        $signature = Signdata::find($id);
        if($signature){
            $signature_all = Signdata::where('assignment_id', $this->assignment->id)->get();
            foreach ($signature_all as $signall) {
                $signall->update([
                    "preferred" => 'N',
                ]);
            }

            $signature->update([
                "preferred" => 'Y',
            ]);
        }

        $this->assignment= Assignment::find($this->assignment->id);
        $this->signs = $this->assignment->signs;

    }

    public function render()
    {
        $this->signs = $this->assignment->signs;

        return view('assignments::livewire.show.tabs.forms.sign', [
            'listSigns' =>  $this->signs
        ]);
    }
}
