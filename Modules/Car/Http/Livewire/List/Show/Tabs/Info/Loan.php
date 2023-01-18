<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Info;

use Livewire\Component;
use Modules\Car\Entities\Car;

class Loan extends Component
{
    protected $listeners = [
        'editLoan' => 'edit',
    ];
    public $show=true;

    public   $car;
    public   $loan_number;
    public   $loan_times;
    public   $down_payment;
    public   $full_amount;



    public function mount(Car $car)
    {
        $this->car = $car;

        $this->loan_number = $this->car->loan_number;
        $this->loan_times = $this->car->loan_times;
        $this->loan_monthly_amount = $this->car->loan_monthly_amount;
        $this->down_payment = $this->car->down_payment;
        $full=($this->loan_times*$this->loan_monthly_amount)+$this->down_payment;
        $this->full_amount =number_format($full,2);

    }
    public function update($formData){

        $id =  $this->car->id;
        $update = $this->car->update($formData);

        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Car Laon Info successfully updated.."
        ]);
        $this->car = Car::find($id);

        $this->loan_number = $this->car->loan_number;
        $this->loan_times = $this->car->loan_times;
        $this->loan_monthly_amount = $this->car->loan_monthly_amount;
        $this->down_payment = $this->car->down_payment;
        $full=($this->loan_times*$this->loan_monthly_amount)+$this->down_payment;
        $this->full_amount =number_format($full,2);

        $this->show = true;
    }
    public function edit(){

        $this->show = !$this->show;

    }
    public function render()
    {
        return view('car::livewire.list.show.tabs.info.loan');
    }
}
