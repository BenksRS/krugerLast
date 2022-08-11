<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Receipts;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Employees\Entities\EmployeeReceipts;
use Modules\User\Entities\User;

class ListAll extends Component
{
    use WithPagination;
    protected $listeners = [
        'backList'

    ];
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $pending;
    public $listReceipts;
    public $showList=true;

    public $selectedRows = 100;

    public function mount(User $user)
    {

        $this->user = $user;
        $this->auth_user = Auth::user();
        $this->getList();
    }
    public function backList(){
        $this->showList=true;
        $this->getList();
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
        $this->listReceipts = EmployeeReceipts::where('user_id', $this->user->id)->orderBy('created_at', 'DESC')->get();
    }
    public function render()
    {
       $list = $this->listReceipts;

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('employees::livewire.show.tabs.receipts.list-all', [
            'list' =>$list
        ]);
    }
}
