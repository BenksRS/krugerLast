<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Employees\Entities\EmployeePaycheck;
use Modules\Employees\Entities\EmployeeReceipts;
use Modules\User\Entities\User;

class Paycheck extends Component
{
    use WithPagination;
    protected $listeners = [
        'backList'

    ];
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $pending;
    public $user;
    public $listPaychecks;
    public $paycheck_id=1000;
    public $showList=false;
    public $showExtra=false;

    public $selectedRows = 100;

    public function mount(User $user)
    {

        $this->user = $user;
        $this->auth_user = Auth::user();
        $this->getList();
    }

    public function showExtra(){
        $this->showExtra = !$this->showExtra;
    }
    public function backList(){
        $this->showList=true;
        $this->getList();
    }
    public function show($id){
        $this->paycheck_id = $id;
        $this->showList = !$this->showList;


    }
    public function edit(){
        $this->showList = !$this->showList;
    }
    public function delete($id){
        EmployeeReceipts::find($id)->delete();
        $this->getList();
    }
    public function approve($id){
        $receipt= EmployeeReceipts::find($id);
        $receipt->update([
            'status'=> 'approved',
            'approved_by'=> $this->auth_user->id,
            'approved_at'=> Carbon::now()
        ]);
        $this->getList();
    }

    public function getList()
    {
        $this->listPaychecks = EmployeePaycheck::where('user_id', $this->user->id)->orderBy('created_at', 'DESC')->get();
    }
    public function render()
    {
        $list = $this->listPaychecks;

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('employees::livewire.show.tabs.paycheck', [
            'list' =>$list
        ]);
    }
}
