<?php

namespace Modules\Referrals\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Auth;
use Modules\Referrals\Repositories\ReferralsRepository;
use Modules\User\Entities\Marketing;

class ListProspects extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Id','Name','Type', 'Marketing','status', 'Address'];
    public $selectedColumns = [];
    public $selectedRows = 100;
    public $marketing;
    public $selectedMarketing;
    public $user;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->marketing = Marketing::all();
        $this->selectedMarketing = $this->marketing->pluck('id')->toArray();
        $this->user = Auth::user();

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = ReferralsRepository::where('status','leed')->Searchtopref($searchAssignment,$this->selectedMarketing)->get();

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('referrals::livewire.list-prospects', [
            'list' =>$list
        ]);

    }
}
