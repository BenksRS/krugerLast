<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Comission;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Entities\EmployeeReceipts;
use Modules\User\Entities\User;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user;
    public $listComissions;
    public $selectedRows = 100;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->auth_user = Auth::user();
        $this->getList();
    }
    public function getList()
    {
        $this->listComissions = EmployeeCommissions::with('rule')->where('user_id', $this->user->id)->where('status','available')
            ->get();


//        with('rule')->where('user_id', $this->user->id)
//            ->where('status','available')
//            ->groupBy('rule_id')
//            ->selectRaw("SUM(amount) as total_debit")
//            ->get();
//        dd($this->listComissions);
    }
    public function render()
    {
        $list = $this->listComissions;

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('employees::livewire.show.tabs.comission.show',
        [
            'list' =>$list
        ]);
    }
}
