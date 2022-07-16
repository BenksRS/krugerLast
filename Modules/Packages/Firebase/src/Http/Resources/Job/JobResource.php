<?php

namespace Callkruger\Api\Http\Resources\Job;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource {

    /**
     * @var array
     */
    public $fields;

    public function __construct ($resource, $fields = [])
    {
        $this->fields = $fields;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray ($request)
    {
        dump($this);
        return [
            'job_id'               => $this->id_assignment,
            'employee_id'          => $this->id_employee,
            'employee_name'        => $this->technician_name,
            'referral_company'     => $this->referral_company,
            'job_type'             => $this->job_types_name,
            'email'                => $this->email,
            'full_name'            => $this->full_name,
            'full_phone'           => $this->full_phone,
            'address'              => [
                'street'  => $this->address,
                'city'    => $this->city,
                'state'   => $this->state,
                'zipcode' => $this->zipcode
            ],
            'status'               => [
                'real' => $this->status_real,
                'new'  => $this->new_status,
            ],
            'total_authorizations' => $this->total_authorizations ?? 0,
            'docusign_sent'        => $this->docusign_sent,
            'event'                => $this->event,
            'nojob'                => $this->nojob,
            'notes'                => $this->note,
            'created_at'           => $this->create_date,
            'scheduled_order_at'   => $this->scheduled_order,
            'scheduled_start_time' => $this->scheduled_start_time,
        ];
    }

}
