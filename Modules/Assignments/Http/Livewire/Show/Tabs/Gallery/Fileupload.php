<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Gallery;


class Fileupload extends Component
{

    use WithFileUploads;

    public $assignment;
    public $type;

    public $photos = [];

    public function mount(Assignment $assignment, $type){
//        ini_set(['memory_limit','4G']);
        $this->assignment = $assignment;
        $this->type = $type;
    }
    public function save(){

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
                'category_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
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
