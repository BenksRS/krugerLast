<?php

namespace Modules\Menu\Http\Livewire;

use Livewire\Component;

class ShowMenuLink extends Component {

    public    $link;



    protected $rules = [
        'link.title'  => 'required',
        'link.icon'   => '',
        'link.url'    => '',
        'link.open'   => '',
        'link.active' => '',
    ];

    public function mount ($link)
    {
        $this->link = $link;
    }

    public function saveLink ()
    {
        $this->link->save();
    }

    public function deleteLink ($link)
    {
        $this->link->delete();
        $this->emit('some-event');
    }

    public function render ()
    {
        return view('menu::livewire.show-menu-link');
    }

}
