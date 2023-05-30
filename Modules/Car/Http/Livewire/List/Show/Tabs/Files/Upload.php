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

            $path = $file->store($this->savePath);

            CarFile::create([
                'car_id' => $this->car,
                'type' => $this->type['key'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'path' => $path
            ]);
        }

        $this->dispatchBrowserEvent('file-uploaded-' . $this->type['key']);
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
