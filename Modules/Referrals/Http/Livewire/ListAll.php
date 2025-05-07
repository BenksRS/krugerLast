<?php

namespace Modules\Referrals\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Repositories\ReferralsRepository;
use Modules\User\Entities\Marketing;

use Auth;

class ListAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Id','Name','Type', 'Marketing','status', 'Address'];
    public $selectedColumns = [];
    public $marketing;
    public $selectedMarketing;
    public $selectedRows = 100;
    public $user;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->marketing = Marketing::all();
        $this->user = Auth::user();
        $this->selectedMarketing = $this->marketing->pluck('id')->toArray();
//        dump($this->columns);
//        dump($this->selectedMarketing);

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = ReferralsRepository::without(['authorizathions'])->Searchtopref($searchAssignment,[2,4,16,49,123,126])->where('status', '!=', 'leed')->get();



        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('referrals::livewire.list-all', [
            'list' =>$list
        ]);

    }

}