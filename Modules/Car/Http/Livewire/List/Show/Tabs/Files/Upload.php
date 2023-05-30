<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Files;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Car\Entities\CarFile;

class Upload extends Component
{
    use WithFileUploads;

    public $type;
    public $car;

    // ** Files Input ** //
    public $files = [];

    //** Save Path **//
    public $savePath = 'public/car-files';


    public function saveFiles()
    {
        foreach ($this->files as $file) {

            $imagedata = file_get_contents($file->path());
            $base64 = base64_encode($imagedata);
            $b64 = 'data:image/jpeg;base64,' . $base64;

            CarFile::create([
                'car_id' => $this->car,
                'type' => $this->type['key'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'path' => $b64
            ]);
        }

        $this->dispatchBrowserEvent('file-uploaded-' . $this->type['key']);
    }


    public function deleteFile($id)
    {
        if ($id) {
            CarFile::find($id)->delete();
        }
    }

    public function getCarFiles()
    {
        return CarFile::where('car_id', $this->car)->where('type', $this->type['key'])->get();
    }

    public function render()
    {
        $items = $this->getCarFiles();
        return view('car::livewire.list.show.tabs.files.upload', ['items' => $items]);
    }
}
