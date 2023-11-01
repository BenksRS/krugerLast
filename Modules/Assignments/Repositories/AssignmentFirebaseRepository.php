<?php

namespace Modules\Assignments\Repositories;

use Carbon\Carbon;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Scopes\AssignmentScope;
use Modules\Notes\Entities\Note;

class AssignmentFirebaseRepository extends Assignment {

    use AssignmentScope;

    protected $with =['scheduling','referral','carrier','status','event','phones','user_updated','user_created','job_types'];

    protected $appends = ['firebase'];

    public function __construct ()
    {
        parent::__construct();
    }

    public function getFirebaseAttribute (){

        $address=(object) [
            'street'  => $this->street,
            'city'    => $this->city,
            'state'   => $this->state,
            'zipcode' => $this->zipcode,
        ];
        if($this->scheduling){
//            dd($this->scheduling->user->name);
            $tech_id=$this->scheduling->tech_id;
            $tech_name=$this->scheduling->tech_id;

            $scheduled_order_at=$this->scheduling->start_date;
            $scheduled_start_time=Carbon::createFromFormat('Y-m-d H:i:s', $scheduled_order_at)->format('H:i');
//            dd($scheduled_start_time);
        }else{
            $tech_id=null;
            $tech_name=null;
            $scheduled_order_at=null;
            $scheduled_start_time=null;
        }

        $job_type = $this->job_types->first();

        if($this->phones){
            $info_phones="";
            $count=0;
            foreach ($this->phones as $phone){
                if($count == 0){
                    $info_phones="$phone->phone";
                }else{
                    $info_phones="$info_phones - $phone->phone";
                }
                $count++;
            }
        }else{
            $info_phones=null;
        }



    $notes_all = Note::where('notable_id', $this->id)->where('type','tech')->get();

        $notes="";
            if(count($notes_all) > 0){
                foreach ($notes_all as $note){
                    $user=$note->user->name;
                    $texto="$note->text - (by $user - $note->created_datetime)";
                    $notes="$notes\\n $texto";
                }
            }

        $count_auth=count($this->authorizations);
        if($this->auth_needed == 'N'){
            $count_auth = 0;
        }else{
            $count_auth = 1;
        }


        $event="";
        if($this->event){
            $event=$this->event->name;
        }

        switch ($this->status_id){
            case 3:
            case 2:
            case 15:
                $status = $this->status->name;
                break;
            default:
                $status = 'delete';
                break;
        }

        $firebase = [
            'job_id'               => $this->id,
            'employee_id'          => $tech_id,
            'employee_name'        => $tech_name,
            'referral_company'     => $this->referral_carrier_full,
            'job_type'             => $job_type->name,
            'email'                => $this->email,
            'full_name'            => $this->full_name,
            'full_phone'           => $info_phones,
            'total_authorizations' => $count_auth,
            'docusign_sent'        => 'No',
            'event'                => $event,
            'nojob'                => null,
            'notes'                => $notes,
            'claim'                => $this->claim_number,
            'adjuster'             => $this->adjuster_info,
            'order'                => $this->status->ordem,
            'created_at'           => $this->date_assignment,
            'scheduled_order_at'   => $scheduled_order_at,
            'scheduled_start_time' => $scheduled_start_time,
            'address'              => $address,
            'status'               => [
                'real' => $status,
                'new'  => $status,
            ],
            'nojob_data'           => [
                'info' => null,
            ]
        ];

        return $firebase;
    }

}
