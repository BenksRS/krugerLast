<?php

namespace Modules\Employees\Http\Livewire\Show\Tabs;

use Carbon\Carbon;
use Livewire\Component;
use Modules\User\Entities\User;

class Comission extends Component
{
    public $user;
    public $dueMonthSelected;
    public $dueYearSelected;
    public $dueYearList=[2022 => '2022', 2023 => '2023', 2024 => '2024', 2025 => '2025'];
    public $dueMonthList=[
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'Aug',
        9 => 'Sept',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec'
    ];
    public function mount(User $user)
    {

        $this->user = $user;
        $this->dueMonthSelected=Carbon::now()->format('n');
        $this->dueYearSelected=Carbon::now()->format('Y');
    }
    public function updated($field)
    {
        if ($field == 'dueYearSelected' || $field == 'dueMonthSelected')
        {
            $this->sendDate();
        }
    }
    public function sendDate(){
        $this->emit('updateDate', ['month' =>$this->dueMonthSelected, 'year' =>$this->dueYearSelected]);
    }
    public function render()
    {
        return view('employees::livewire.show.tabs.comission');
    }
}
