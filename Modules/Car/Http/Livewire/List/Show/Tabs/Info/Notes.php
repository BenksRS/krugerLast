<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Info;

use Livewire\Component;
use Modules\Car\Entities\Car;
use Auth;
class Notes extends Component
{
    public $car;
    public $notesList;
    public $user;
    public $notetext;
    public $showinfo = false;

    public $old_paid_info;
    public $old_billing_info;



    public function mount(Car $car)
    {
        $this->car = $car;
        $this->notesList = $this->car->notes;
        $this->user = Auth::user();


    }

    public function showAdd(){
        $this->showinfo = true;
    }
    public function addNewNote(){


        $this->car->notes()->create([
            'text'=> $this->notetext,
            'notable_id'=> $this->car->id,
            'created_by'=> $this->user->id,
            'type'=> 'car',
            'notable_type'=>  Car::class,
        ]);

        $this->notetext = null;
        $this->showinfo = false;

        $this->car = Car::find($this->car->id);
//        sleep(0.5);
        $this->notesList = $this->car->notes->where('type','car');

    }
    public function render()
    {
        return view('car::livewire.list.show.tabs.info.notes', [
            'notesListAll' => $this->notesList,
            'show' => $this->showinfo,
        ]);
    }
}
