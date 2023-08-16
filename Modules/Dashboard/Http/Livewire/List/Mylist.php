<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssugnmentsMylist;
use Modules\Assignments\Repositories\AssignmentRepository;
use Auth;

class Mylist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $user;
    public $myjobs=[];
    public $columns = ['Name','Job Type','Schedule','Status','Referral','Address','Street','City','State', 'Phone', 'Created by', 'Created At', 'Update By','Update At'];
    public $selectedColumns = [];
    public $selectedRows = 100;

    public function mount()
    {
        $this->user = Auth::user();
        $this->myjobs=AssugnmentsMylist::where('user_id',$this->user->id)->pluck('assignment_id');

        
        $this->selectedColumns = $this->columns;

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function render()
    {

        $list=Assignment::with(['scheduling','referral','carrier','status','event','phones','user_updated','user_created','job_types','invoices'])
            ->whereIn('id',$this->myjobs)
            ->orderBy('id', 'DESC');


        $list = $list->paginate($this->selectedRows);

        return view('dashboard::livewire.list.mylist', [
            'list' =>$list
        ]);

    }
//    public function render()
//    {
//        return view('dashboard::livewire.list.mylist');
//    }
}
