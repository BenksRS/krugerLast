<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Gallery;

use Livewire\Component;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\Gallery;
use Modules\Assignments\Entities\GalleryCategory;

class Images extends Component
{
    protected $listeners = [
        'uploadPics' => 'processUploadpics',
        'imageUploaded' => 'processImageUploaded',
    ];
    public $showFront, $showInside, $showBefore, $showAfter = false;
    public $assignment;
    public $gallery;




    public function mount(Assignment $assignment)
    {
        ini_set('memory_limit','1G');

        $this->assignment = $assignment;
        $this->tasks = GalleryCategory::all();
        $this->gallery = Gallery::where('assignment_id', $this->assignment->id)->get();

    }
    public function updateTaskOrder($galleryReturn){
//dd($galleryReturn);
        foreach ( $galleryReturn as $gallery){
            $type = $gallery['value'];

            foreach ($gallery['items'] as $item){
                $update=['type'=> $type];
                $image = Gallery::find($item['value']);
                $image->update($update);
            }

        }
        $this->gallery = Gallery::where('assignment_id', $this->assignment->id)->get();
    }
    public function processImageUploaded(){
        $this->showFront = $this->showInside = $this->showBefore = $this->showAfter = false;
        $this->gallery = Gallery::where('assignment_id', $this->assignment->id)->get();
    }
    public function processUploadpics($type){


        switch ($type){
            case "start_job";
                $this->showFront = true;
                break;
            case "pics_inside";
                $this->showInside = true;
                break;
            case "pics_before";
                $this->showBefore = true;
                break;
            case "pics_after";
                $this->showAfter = true;
                break;
        }



    }
    public function deleteImage($id){

        $deletesImage = Gallery::find($id);
        if($deletesImage){
            $deletesImage->delete();

            $this->gallery = Gallery::where('assignment_id', $this->assignment->id)->get();
        }

    }
    public function render()
    {
        return view('assignments::livewire.show.tabs.gallery.images',[
            'listGallery' => $this->gallery
        ]);
    }
}
