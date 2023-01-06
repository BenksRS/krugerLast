<?php

    namespace Modules\Password\Http\Livewire;

    use Livewire\Component;
    use Modules\Password\Entities\Password;

    class Show extends Component {

        public $search;

        protected $listeners = ['$refresh'];

        public function render ()
        {
            $passwords = Password::with(['user_created', 'user_updated'])->when($this->search, function ( $query, $search ) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('url', 'like', '%' . $search . '%');
                $query->orWhere('username', 'like', '%' . $search . '%');
            })->orderBy('name')->get();

            return view('password::livewire.show', compact('passwords'));
        }

    }
