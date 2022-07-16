<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Gallery;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Gdrive\Entities\gdrive;
use Modules\Gdrive\Entities\QueeDir;
use Modules\Gdrive\Entities\QueeFiles;

class Links extends Component
{
    public $assignment;
    public $gdrive;
    public $quee_dir;
    public $quee_files;

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->gdrive = gdrive::where('assignment_id', $this->assignment->id)->first();
        $this->reloadInfo();
    }

    public function reloadInfo(){

        $this->quee_dir= QueeDir::where('assignment_id', $this->assignment->id)->first();
        $this->quee_files= QueeFiles::where('assignment_id', $this->assignment->id)->where('status', '!=', 'complete')->first();


        if(isset($this->quee_dir)){
            if($this->quee_dir->status != 'processing'){
                $this->gdrive = gdrive::where('assignment_id', $this->assignment->id)->first();
            }
        }


    }
    public function addFilesQueue(){
        $now=Carbon::now();
        QueeFiles::where('assignment_id', $this->assignment->id)->delete();

        $history= "<b># Added to queue</b> - $now";
        QueeFiles::create([
            'assignment_id' =>$this->assignment->id,
            'order' =>50,
            'status' =>'pending',
            'history' =>$history
        ])->save();

        $this->reloadInfo();
    }

    public function addDirQuee()
    {
        $now=Carbon::now();
        $history= "<b># Added to queue</b> - $now";
        QueeDir::create([
            'assignment_id' =>$this->assignment->id,
            'order' =>50,
            'status' =>'pending',
            'history' =>$history
        ])->save();

        $this->reloadInfo();
    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.gallery.links');
    }
}
