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
        $carFiles = [];

        foreach ($this->files as $file) {

            $fileData = file_get_contents($file->path());

            // Isto vai retornar 'application/pdf', 'image/png', etc.
            $mimeType = $file->getMimeType();

            $base64 = base64_encode($fileData);

            $b64 = 'data:' . $mimeType . ';base64,' . $base64;

            $carFiles[] = [
                'car_id' => $this->car,
                'type' => $this->type['key'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'path' => $b64
            ];
        }

        CarFile::insert($carFiles);

        $this->reset(['files']);
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