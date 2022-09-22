<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Docsign;

class Doscusign extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'uploadAuth' => 'uploadAuth',
    ];
    public $listAuth;
    public $assignment;
    public $showUploading=false;

    public $newauth;

    public function mount(Assignment $assignment){

        $this->assignment = $assignment;
        $this->listAuth=Docsign::where('assignment_id', $this->assignment->id)->get();

    }
    public function uploadAuth(){
        $this->showUploading = !$this->showUploading;
    }
    public function save(){

//        $this->validate([
//            'newauth' => 'mimes:pdf',
//        ]);

        if($this->newauth){
//        dd($this->newauth);
            $imagedata = file_get_contents($this->newauth->path());
            $name=$this->newauth->getClientOriginalName();
            $base64 = base64_encode($imagedata);
            $b64=$base64;

            $created = Docsign::create([
                'assignment_id' => $this->assignment->id,
                'name' => $name,
                'b64' => $b64,
            ]);

            $this->newauth = null;
            $this->showUploading = false;
            $this->listAuth=Docsign::where('assignment_id', $this->assignment->id)->get();

        }


    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.forms.doscusign');
    }
}
