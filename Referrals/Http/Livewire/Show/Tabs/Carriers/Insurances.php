<?php

namespace Modules\Referrals\Http\Livewire\Show\Tabs\Carriers;

use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithPagination;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;

class Insurances extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'carrierUpdate' => 'processCarrier'
    ];
    public $referral;

    public $insuranceLists;
    public $carrierLists;
    public $searchTerm = '';


    public function mount(Referral $referral)
    {
        $this->referral = $referral;
        $this->carrierLists = $this->referral->carriers()->pluck('referral_carrier_id');

        $this->insuranceLists = Referral::select('company_fictitions', 'company_entity')->where('referral_type_id', 2)->whereNotIn('id',$this->carrierLists)->get();

    }
    public function processCarrier($id){
        $this->referral = Referral::find($id);
        $this->carrierLists = $this->referral->carriers()->pluck('referral_carrier_id');
        $this->searchTerm='';
    }
    public function addCarrier($carrier_id){

        $this->referral->carriers()->attach($carrier_id);

        $this->referral = Referral::find($this->referral->id);
        $this->carrierLists = $this->referral->carriers()->pluck('referral_carrier_id');

        $this->searchTerm='';

        $this->emit('pivotUpdate',$this->referral->id);
        $this->emit('checkAuthorizations',$this->referral->id);
    }

    public function render()
    {

         $list =Referral::where('referral_type_id', 2)
             ->where(function ($sub_query){
                 $searchTerm = "%$this->searchTerm%";
                 $sub_query->where('company_entity', 'LIKE',$searchTerm)
                     ->orWhere('company_fictitions', 'LIKE',$searchTerm);
             })
             ->whereNotIn('id',$this->carrierLists)
             ->orderBy('company_entity', 'ASC')
             ->paginate(10);


        return view('referrals::livewire.show.tabs.carriers.insurances', [
            'list' =>$list
        ]);

    }
}
