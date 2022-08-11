<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Comission;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Entities\EmployeeReceipts;
use Modules\Employees\Entities\EmployeeRules;
use Modules\User\Entities\User;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'updateDate'
    ];
    public $user;
    public $listComissions;
    public $selectedRows = 100;
    public $isActive;
    public $trigger;
    public $slot;


    public function mount(User $user)
    {

        $this->user = $user;
        $this->auth_user = Auth::user();
        $this->dueMonthSelected=Carbon::now()->format('n');
        $this->dueYearSelected=Carbon::now()->format('Y');

        $this->getList($this->dueMonthSelected, $this->dueYearSelected);
    }

    public function updateDate($data){
        $this->dueMonthSelected=$data['month'];
        $this->dueYearSelected=$data['year'];
        $this->getList($this->dueMonthSelected, $this->dueYearSelected);
    }
    public function showMoney($var){
        return number_format($var,2);
    }
    public function setActive($id){
        $this->isActive=$id;
        $this->getList($this->dueMonthSelected, $this->dueYearSelected);
    }
    public function getList($due_month, $due_year)
    {

        $due_month=(int)$due_month;
        $due_year=(int)$due_year;

//        dd($due_year);


        $commissions = EmployeeCommissions::with('rule','assignment','user')->where('user_id', $this->user->id)
            ->whereIn('status',['available','paid'])
            ->where('due_month',$due_month)
            ->where('due_year',$due_year)
            ->get();

//        dd($commissions);

        $Commissions_rule=$commissions->groupBy('rule_id');


        if(count($Commissions_rule) > 0){
            foreach ( $Commissions_rule as $key => $jobs){
                $rule=EmployeeRules::with('referral')->find($key);

                $total = $jobs->sum('amount');


                $total_jobs=count($jobs);
                $coll[]=(object)[
                    'id' => $key,
                    'rule' => $rule,
                    'jobs' => $jobs,
                    'total_jobs' => $total_jobs,
                    'total' => $total,
                    'due_month' => $due_month,
                    'due_year' => $due_year
                ];
        }


            // result
            $coll=collect($coll);
        }else{
            $coll = [];
        }
        $this->listComissions = $coll;



    }
    public function render()
    {


        return view('employees::livewire.show.tabs.comission.show');
    }
}
