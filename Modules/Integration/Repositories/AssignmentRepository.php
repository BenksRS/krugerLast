<?php

namespace Modules\Integration\Repositories;

use Carbon\Carbon;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Assignments\Scopes\AssignmentScope;
use Modules\Notes\Entities\Note;

class AssignmentRepository extends Assignment {

    use IntegrationRepository;

    use AssignmentScope;

    protected $with    = ['scheduling', 'referral', 'carrier', 'status', 'event', 'phones', 'user_updated', 'user_created', 'job_types'];

    protected $appends = ['firebase'];

    protected $dates   = [
        'created_at',
        'scheduled_order_at',
    ];

    public function __construct ()
    {
        parent::__construct();
    }

    public function setData ($data)
    {
        $status = AssignmentsStatus::where('name', $data['status']['new'])->first();

        return [
            'status_id' => $status->id,
        ];
    }

    public function getData ()
    {

        $address = [
            'street'  => $this->street,
            'city'    => $this->city,
            'state'   => $this->state,
            'zipcode' => $this->zipcode,
        ];
        if ( $this->scheduling ) {
            //            dd($this->scheduling->user->name);
            $tech_id   = $this->scheduling->tech->id;
            $tech_name = $this->scheduling->tech->name;

            $scheduled_order_at   = $this->scheduling->start_date;
            $scheduled_start_time = $this->scheduling->start_hour;
            //            dd($scheduled_start_time);
        } else {
            $tech_id              = NULL;
            $tech_name            = NULL;
            $scheduled_order_at   = NULL;
            $scheduled_start_time = NULL;
        }

        $job_type = $this->job_types->first();

        if ( $this->phones ) {
            $info_phones = "";
            $count       = 0;
            foreach ( $this->phones as $phone ) {
                if ( $count == 0 ) {
                    $info_phones = "$phone->phone";
                } else {
                    $info_phones = "$info_phones - $phone->phone";
                }
                $count ++;
            }
        }else{
            $info_phones = NULL;
        }
        $notes="";

        $notesTech = Note::where('notable_id', $this->id)->where('type','tech')->get();

                    if(count($notesTech) > 0){

                        foreach ($notesTech as $nota){
                            $user=$nota->user->name;
                            $notes=$notes."$nota->text - ($user - $nota->created_datetime)\n";
                        }
                    }

        $count_auth = count($this->authorizations);
        $count_auth= 1;
        $event      = "";
        if ( $this->event ) {
            $event = $this->event->name;
        }

        switch ( $this->status_id ) {
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
            'docusign_sent'        => FALSE,
            'event'                => $event,
            'nojob'                => NULL,
            'notes'                => $notes,
            'claim'                => $this->claim_number,
            'adjuster'             => $this->adjuster_info,
            'order'                => (int) $this->status->ordem,
            'created_at'           => $this->date_assignment,
            'scheduled_order_at'   => $scheduled_order_at,
            'scheduled_start_time' => $scheduled_start_time,
            'address'              => $address,
            'status'               => [
                'real' => $status,
                'new'  => $status,
            ],
            'nojob_data'           => [
                'info' => NULL,
            ],
            'sync_delete'          => $status == 'delete' ? TRUE : FALSE,
        ];

        return $firebase;
    }

}