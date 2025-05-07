<?php

namespace Modules\Referrals\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Referrals\Repositories\ReferralsRepository;
use Modules\User\Entities\Marketing;

class ListInactives extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Id','Name','Type', 'Marketing','status', 'Address'];
    public $selectedColumns = [];
    public $selectedJobsSent = ['Y','N'];
    public $marketing;
    public $selectedMarketing;

    public $selectedStatus=['ACTIVE','BLOCKED'];
    public $selectedRows = 100;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->marketing = Marketing::all();
        $this->selectedMarketing = $this->marketing->pluck('id')->toArray();


    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = ReferralsRepository::without(['authorizathions'])->Searchtopref($searchAssignment,$this->selectedMarketing)->whereIn('status',$this->selectedStatus)->get();

        $list = $list->sortByDesc('jobs_sent')->sortByDesc('days_last_job');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('referrals::livewire.list-inactives', [
            'list' =>$list
        ]);

    }

}