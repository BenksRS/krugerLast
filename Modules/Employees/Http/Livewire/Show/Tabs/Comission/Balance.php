<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs\Comission;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\User\Entities\User;

class Balance extends Component
{
    protected $listeners = [
        'updateDate'
    ];
    public $user;
    public $pending=0;
    public $available=0;
    public $availableDueMonth=0;
    public $availableBeforeMonth=0;
    public $current=0;
    public $balanceMonthActual=0;
    public $balanceMonthBefore=0;
    public $dueMonthSelected;
    public $dueMonthShow;
    public $dueMonthNext;
    public $dueYearNext;
    public $dueYearSelected;
    public $dueYearShow;

    public $MonthActual;
    public $YearActual;
    public $beforeMonthActual;
    public $beforeYearActual;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->MonthActual=Carbon::now()->format('M');
        $this->YearActual=Carbon::now()->format('Y');

        $this->getBalances();

        $this->dueMonthSelected=Carbon::now()->format('n');
        $this->dueMonthShow=Carbon::now()->format('M');
        $this->dueYearSelected=Carbon::now()->format('Y');

        $this->dueMonthNext=Carbon::now()->addMonth()->format('M');
        $this->dueYearNext=Carbon::now()->addMonth()->format('Y');

        $available=EmployeeCommissions::where('user_id', $this->user->id)->where('status', 'available')->get();
        $this->available=$available->sum('amount');

//        $availableDueMonth


        $pending=EmployeeCommissions::where('user_id', $this->user->id)->where('status', 'pending')->get();
        $this->pending=$pending->sum('amount');

        $this->getList($this->dueMonthSelected, $this->dueYearSelected);
    }


    public function updateDate($data){
        $this->dueMonthSelected=$data['month'];
        $this->dueYearSelected=$data['year'];

        $date= Carbon::create()->startOfMonth()->month($data['month'])->year($data['year'])->startOfMonth()->format('m/d/Y');
        $nextMonth = Carbon::createFromFormat('m/d/Y', $date)->addMonth()->format('m/d/Y');

//        dd($nextMonth);

        $this->dueMonthNext=Carbon::createFromFormat('m/d/Y', $nextMonth)->format('M');
        $this->dueYearNext=Carbon::createFromFormat('m/d/Y', $nextMonth)->format('Y');

        $this->dueMonthShow = Carbon::create()->startOfMonth()->month($data['month'])->startOfMonth()->format('M');


        $this->getList($this->dueMonthSelected, $this->dueYearSelected);

    }
    public function showMoney($var){
        return number_format($var,2);
    }

    public function getBalances()
    {
        $month=(int)Carbon::now()->format('n');
        $year=(int)Carbon::now()->format('Y');

        $commissions = EmployeeCommissions::with('rule', 'assignment', 'user')->where('user_id', $this->user->id)
            ->where('due_month', $month)
            ->where('due_year', $year)
            ->where('status', 'available')
            ->get();
//
        $commissionsTotal = EmployeeCommissions::with('rule', 'assignment', 'user')->where('user_id', $this->user->id)
            ->where('status', 'available')
            ->get();


        if(count($commissionsTotal) > 0 ){
            $comTotal = $commissionsTotal->sum('amount');
            $this->balanceMonthActual=$commissions->sum('amount');
            $this->balanceMonthBefore=$comTotal-$this->balanceMonthActual;
        }else{
            $this->balanceMonthActual=0;
        }

    }

    public function getList($due_month, $due_year)
    {

        $due_month = (int)$due_month;
        $due_year = (int)$due_year;

        $commissions = EmployeeCommissions::with('rule', 'assignment', 'user')->where('user_id', $this->user->id)
            ->where('due_month', $due_month)
            ->where('due_year', $due_year)
            ->get();

        if(count($commissions) > 0){
            $this->current=$commissions->sum('amount');
        }else{
            $this->current=0;
        }


    }
    public function render()
    {
        return view('employees::livewire.show.tabs.comission.balance');
    }
}