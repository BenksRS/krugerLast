<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Gallery;

use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Gallery;


class Fileupload extends Component
{

    use WithFileUploads;

    public $assignment;
    public $type;
    public $user;

    public $photos = [];

    public function mount(Assignment $assignment, $type){
//        ini_set(['memory_limit','4G']);
        $this->assignment = $assignment;
        $this->type = $type;
        $this->user = Auth::user();
    }
    public function save(){
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '2000M');
        ini_set('max_input_time', 300);
        ini_set('max_execution_time', 300);

        $this->validate([
            'photos.*' => 'mimes:jpg,jpeg,png',
        ]);



        foreach ($this->photos as $photo) {
//            dd($photo);
            $imagedata = file_get_contents($photo->path());
            $base64 = base64_encode($imagedata);
            $b64='data:image/jpeg;base64,'.$base64;

      Gallery::create([
                'assignment_id' => $this->assignment->id,
                'category_id' => 25,
                'created_by' => $this->user->id,
                'updated_by' => $this->user->id,
                'img_id' => rand(2,500),
                'b64' => $b64,
                'type' => $this->type,
            ])->save();
        }

        $this->emit('imageUploaded');
    }

    public function render()
    {
        return view('assignments::livewire.show.tabs.gallery.fileupload');
    }
}
