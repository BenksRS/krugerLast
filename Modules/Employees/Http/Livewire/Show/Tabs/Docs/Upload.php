<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Docs;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Employees\Entities\EmployeeDoc;

class Upload extends Component
{

    use WithFileUploads;

    public $type;
    public $user;

    public $files = [];


    public function saveFiles()
    {

        $typeFiles = [];

        foreach ($this->files as $file) {

            $imagedata = file_get_contents($file->path());
            $base64 = base64_encode($imagedata);
            $b64 = 'data:image/jpeg;base64,' . $base64;

            $typeFiles[] = [
                'user_id' => $this->user,
                'type' => $this->type['key'],
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'path' => $b64
            ];
        }

        EmployeeDoc::insert($typeFiles);

        $this->reset(['files']);
        $this->dispatchBrowserEvent('file-uploaded-' . $this->type['key']);
    }


    public function deleteFile($id)
    {
        if ($id) {
            EmployeeDoc::find($id)->delete();
        }
    }

    public function getDocs()
    {
        return EmployeeDoc::where('user_id', $this->user)->where('type', $this->type['key'])->get();
    }


    public function render()
    {
        $items = $this->getDocs();
        return view('employees::livewire.show.tabs.docs.upload', ['items' => $items]);
    }
}
