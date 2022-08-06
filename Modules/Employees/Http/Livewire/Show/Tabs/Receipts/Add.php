<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Receipts;

use Illuminate\Http\Request;
use Livewire\Component;

class Add extends Component
{


    public function upload(Request $request){
//        $photos = $request->file('file');
        dump($request->files);
//        foreach ($photos as $photo) {
//
//            $imagedata = file_get_contents($photo->path());
//            $base64 = base64_encode($imagedata);
//            $b64 = 'data:image/jpeg;base64,' . $base64;
//
//
//        }

    }
    public function render()
    {
        return view('employees::livewire.show.tabs.receipts.add');
    }
}
