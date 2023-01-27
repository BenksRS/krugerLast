<?php

namespace Modules\Car\Http\Livewire\List\Show\Tabs\Manutencao;

use Livewire\Component;
use Modules\Assignments\Entities\JobReportWorkers;
use Modules\Car\Entities\Car;
use Modules\Car\Entities\CarsChanges;
use Auth;
use Modules\Car\Entities\CarsLogs;

class Add extends Component
{
    public $car;
    public $carChanges;
    public $carChangesDB;
    public $syncChanges=[];

    public $log_id;

    public $log_date;
    public $miles;
    public $text;

    public $user;


    public $check_oil;
    public $check_oil_filter;
    public $check_fuel_filter;
    public $check_air_filter;
    public $check_break;
    public $check_windshield;
    public $check_front_tires;
    public $check_rear_tires;
    public $check_tire_pressure;





    public function mount(Car $car)
    {
        $this->car = $car;
        $this->carChanges = CarsChanges::all()->sortBy('order');

        $this->user = Auth::user();

    }

    public function syncChanges($id){
            if(in_array($id, $this->syncChanges)){
                $this->syncChanges = array_diff($this->syncChanges, array($id));
            }else{
                $this->syncChanges[] = $id;
            }
    }

   public function saveLog($formData){
       $this->log_date = $formData['log_date'];
       $array=implode(",",$this->syncChanges);

       $data = [
           'car_id' => $this->car->id,
           'miles' => $this->miles,
           'date' => $this->log_date,
           'check_oil' => $this->check_oil,
           'check_break' =>$this->check_break,
           'check_fuel_filter' =>$this->check_fuel_filter,
           'check_windshield' =>$this->check_windshield,
           'check_front_tires' =>$this->check_front_tires,
           'check_rear_tires' =>$this->check_rear_tires,
           'check_air_filter' =>$this->check_air_filter,
           'check_oil_filter' =>$this->check_oil_filter,
           'check_tire_pressure' =>$this->check_tire_pressure,
           'changes' =>$array,
           'text' =>$this->text,
           'created_by' => $this->user->id,
           'updated_by' => $this->user->id
       ];

       if(is_null($this->log_id)){
           // INSERT job Report
           CarsLogs::create($data)->save();
       }else{
//           $this->jobReport->update($data);
       }
       $this->emit('backList');
   }


    public function render()
    {
        return view('car::livewire.list.show.tabs.manutencao.add');
    }
}
