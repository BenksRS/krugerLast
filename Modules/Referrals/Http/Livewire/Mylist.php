<?php

namespace Modules\Referrals\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Referrals\Repositories\ReferralsRepository;

use Auth;

class Mylist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Id','Name','Type', 'Marketing','status', 'Address'];
    public $selectedColumns = [];
    public $selectedRows = 100;
    public $user;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->user = Auth::user();

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = ReferralsRepository::where('marketing_id', $this->user->id)->where('status','leed')->Searchtopref($searchAssignment)->get();

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('referrals::livewire.mylist', [
            'list' =>$list
        ]);

    }
}
