<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Forms;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Docsign;
use Modules\Gdrive\Entities\QueeForms;

class Doscusign extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'uploadAuth' => 'uploadAuth',
    ];
    public $listAuth;
    public $quee_forms;
    public $assignment;
    public $showUploading=false;

    public $newauth;

    public function mount(Assignment $assignment){

        $this->assignment = $assignment;
        $this->listAuth=Docsign::where('assignment_id', $this->assignment->id)->get();
        $this->reloadInfo();
    }
    public function uploadAuth(){
        $this->showUploading = !$this->showUploading;
    }
    public function reloadInfo(){
        $this->quee_forms= QueeForms::where('assignment_id', $this->assignment->id)->where('type', 'docusign')->where('status', '!=', 'complete')->first();
    }
    public function save(){


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

            $this->assignment->tags()->attach(9);

            $this->emit('updateScheduling');



        }


    }
    public function addFormQueue(){
        $now=Carbon::now();
        QueeForms::where('assignment_id', $this->assignment->id)->where('type','docusign')->delete();

        $history= "<b># Added to queue</b> - $now";
        QueeForms::create([
            'assignment_id' =>$this->assignment->id,
            'order' =>50,
            'status' =>'pending',
            'type' =>'docusign',
            'history' =>$history
        ])->save();

        $this->reloadInfo();
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.forms.doscusign');
    }
}
