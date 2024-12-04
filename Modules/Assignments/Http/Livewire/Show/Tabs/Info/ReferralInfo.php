<?php

namespace Modules\Assignments\Http\Livewire\Show\Tabs\Info;

use Carbon\Carbon;
use Livewire\Component;
use Manny\Manny;
use Modules\Assignments\Entities\Assignment;
use Modules\Referrals\Entities\Referral;

class ReferralInfo extends Component
{
    public $show = true;
    protected $listeners = [
        'jobtypeUpdate' => 'processJobtype',
        'referralUpdate' => 'processReferral',
        'editReferralinfo' => 'edit',
        'contentChange' => 'processContent',
        'contentCC' => 'getCCalacrity',
    ];

    public $assignment;
    public $carrier;

    public $referralSelected;
    public $carrierSelected;
    public $carrierLists;
    public $showCarrierSelect = true;

    public $referralList;
    public $carrierList = array();

    public $polling = true;


    public $referral;
    public $pre_referral;
    public $referral_id;
    public $referral_type_id;

    public $carrier_id;
    public $carrier_info;
    public $claim_number;
    public $client_id;
    public $date_of_loss;
    public $adjuster_info;

    public $CC_alacrity="-";
    public $PI_alacrity="-";
    public $SI_alacrity="-";


    protected $rules = [
        'referral_id' => 'required',
    ];


    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->carrier = $this->assignment->carrier()->first();

        $this->referral_id = $this->assignment->referral->id;
        $this->referralSelected = $this->assignment->referral->id;
        if($this->carrier){
            $this->carrierSelected = $this->carrier->id;
        }

        if($this->referral_id == 24){
            $this->getCCalacrity();
            $this->getVisitDate();
        }


        $this->referral_type_id = $this->assignment->referral->referral_type_id;
        $this->date_of_loss = $this->assignment->date_of_loss;
        $this->adjuster_info = $this->assignment->adjuster_info;
        $this->carrier_info = $this->assignment->carrier_info;
        $this->client_id = $this->assignment->client_id;
        $this->claim_number = $this->assignment->claim_number;

        $this->allReferrals = Referral::where('status', 'ACTIVE')->get();

        $this->processCarrier($this->referral_id);

    }
	
	public function alacrityVisitSite($date){
		
		if($this->assignment->referral->id == 24) {
			// alacrity time zone
			switch ($this->assignment->state) {
				case 'LA':
				case 'TX':
					$ContactDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->subHours(1)->format('Y-m-d H:i:s');
					break;
				default:
					$ContactDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
					break;
			}
			
			alacrity_service()->post('UpdateDates', ['AssignmentId' => $this->assignment->allacrity_id],
				["AssignmentDates" => [
					'VisitDate' => $ContactDate
				]]);
			$this->getCCalacrity();
			$this->emit('contentCC');
		}
		
	}
	
	public function getVisitDate(){
		$firstImage = $this->assignment->gallery->first();
		$firstImageDate = $firstImage->created_at ?? null;
		
		if($firstImageDate && $this->SI_alacrity == 'No action') {
			$this->alacrityVisitSite($firstImageDate);
		}
		
	}


    public function getCCalacrity(){
			
        if(isset($this->assignment->allacrity_id)){
					
	

            $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> $this->assignment->allacrity_id]);

            if($alacrity){
                if($alacrity=$alacrity['AssignmentDetail']['AssignmentDates']){


                    // alacrity time zone
                    switch ($this->assignment->state){
                        case 'LA':
                            $this->CC_alacrity=($alacrity['ContactDate'] == '') ? 'No action' : Carbon::createFromFormat('Y-m-d H:i:s', $alacrity['ContactDate'])->addHour(1)->format('m/d/Y g:i A');;
                            $this->PI_alacrity=($alacrity['ScheduledVisitDate']== '') ? 'No action' : Carbon::createFromFormat('Y-m-d H:i:s', $alacrity['ScheduledVisitDate'])->addHour(1)->format('m/d/Y g:i A');
                            $this->SI_alacrity=($alacrity['VisitDate']== '') ? 'No action' : Carbon::createFromFormat('Y-m-d H:i:s', $alacrity['VisitDate'])->addHour(1)->format('m/d/Y g:i A');

                            break;
                        default:
                            $this->CC_alacrity=($alacrity['ContactDate'] == '') ? 'No action' : Carbon::createFromFormat('Y-m-d H:i:s', $alacrity['ContactDate'])->format('m/d/Y g:i A');;
                            $this->PI_alacrity=($alacrity['ScheduledVisitDate']== '') ? 'No action' : Carbon::createFromFormat('Y-m-d H:i:s', $alacrity['ScheduledVisitDate'])->format('m/d/Y g:i A');
                            $this->SI_alacrity=($alacrity['VisitDate']== '') ? 'No action' : Carbon::createFromFormat('Y-m-d H:i:s', $alacrity['VisitDate'])->format('m/d/Y g:i A');
                            break;
                    }





                }else{
                    $this->CC_alacrity='Error Connect AlecNet';
                    $this->PI_alacrity='Error Connect AlecNet';
                    $this->SI_alacrity='Error Connect AlecNet';
                }
            }

        }else{
            $this->updateAlacrityId();
        }
    }
    public function updateAlacrityId(){
        $alacrity=alacrity_service()->post('SearchAssignment', [],['SearchString'=> $this->assignment->claim_number]);

        if(isset($alacrity['AssignmentSummaryList'][0])) {
            $formData['allacrity_id'] = $alacrity['AssignmentSummaryList'][0]['AssignmentId'];

            $id = $this->assignment->id;
            $update = $this->assignment->update($formData);
            $this->assignment = Assignment::find($id);

            $this->getCCalacrity();
        }
    }

    public function processContent(){
        $this->carrierLists=[];
        $this->processCarrier($this->referralSelected);

    }
    public function togglePolling()
    {
        $this->polling = !$this->polling;
    }
    public function processCarrier($id){
        $this->referral = Referral::find($id);
        $this->carrierLists = $this->referral->carriers;

        if(count($this->carrierLists) > 0){
            $this->showCarrierSelect = true;
        }else{
            $this->showCarrierSelect = false;
        }
    }
    public function validCarrierList($referral_id){
        $this->referral = Referral::find($referral_id);

        $this->carrierList = $this->referral->carriers;

    }
    public function edit(){

        $this->show = !$this->show;

    }
    public function updated($field)
    {
        if ($field == 'referralSelected')
        {
            $this->emit('contentChange');
        }
    }
    public function processReferral($id){
        $this->referral = Referral::find($id);

        $this->validCarrierList($id);

    }
    public function processJobtype($id){
        $this->assignment = Assignment::find($id);
    }
	
		protected function processCarrierTags ()
		{
/*			$carriersTags  = config('referrals.carriers_tags');
			dd($carriersTags);*/
			$tagId        = 39;
			$referralIds  = [24, 674, 72, 104];
			$carrierIds   = [217, 496];
			
			$referral   = $this->assignment->referral_id ?? 0;
			$carrier    = $this->assignment->carrier_id ?? 0;
			$tags       = $this->assignment->tags->pluck('id');
			
			if ((in_array($referral, $referralIds) || in_array($carrier, $carrierIds)) && !$tags->contains($tagId)) {
				$this->assignment->tags()->attach($tagId);
				$this->emit('tagsUpdate', $this->assignment->id);
				integration('assignments')->set($this->assignment->id);
			}
		}
    public function update($formData){
        $this->validate();

        if($formData['date_of_loss'] == ''){
            $formData['date_of_loss'] = null;
        }

        $errors = $this->getErrorBag();

        $id =  $this->assignment->id;
        $update = $this->assignment->update($formData);

        session()->flash('alert' ,[
            'class' => 'success',
            'message' => "Referral Info successfully updated.."
        ]);
        $this->assignment = Assignment::find($id);
        $this->date_of_loss = $this->assignment->dol_date;
        $this->adjuster_info = $this->assignment->adjuster_info;
        $this->carrier_info = $this->assignment->carrier_info;
        $this->claim_number = $this->assignment->claim_number;
        $this->client_id = $this->assignment->client_id;
				
				$this->processCarrierTags();

        $this->show = true;
    }
    public function render()
    {
        $this->validCarrierList($this->referral_id);
        return view('assignments::livewire.show.tabs.info.referral-info',[
            'cList' => $this->carrierList
        ]);
    }
}