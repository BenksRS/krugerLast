<?php

namespace Modules\Charts\Http\Livewire;

use Livewire\Component;

class Filters extends Component {

    public $filters = [];

    protected $rules = [
        'filters.start' => 'required',
        'filters.end'   => 'required',
    ];

    protected $listeners = [
        'filter' => 'filter',
    ];

    public function filterDate ()
    {
        $validatedData = $this->validate();

        $this->emitUp('filter', $this->filters);
    }

    public function render ()
    {
        return view('charts::livewire.filters');
    }

}
