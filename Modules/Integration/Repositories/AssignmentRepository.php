<?php
	
	namespace Modules\Integration\Repositories;
	
	use Carbon\Carbon;
	use Modules\Assignments\Entities\Assignment;
	use Modules\Assignments\Entities\AssignmentsStatus;
	use Modules\Assignments\Entities\Nojob;
	use Modules\Assignments\Scopes\AssignmentScope;
	use Modules\Notes\Entities\Note;
	
	class AssignmentRepository extends Assignment {
		
		use IntegrationRepository;
		
		use AssignmentScope;
		
		protected $with    = [
			'scheduling', 'referral', 'carrier', 'tags', 'status', 'event', 'phones', 'user_updated', 'user_created',
			'job_types'
		];
		
		protected $appends = ['firebase'];
		
		protected $dates   = [
			'created_at',
			'scheduled_order_at',
		];
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function setData($data)
		{
			$assignmentId = $data['job_id'];
			$employeeId   = $data['employee_id'] ?? 73;
			
			$status   = AssignmentsStatus::where('name', $data['status']['new'])->first();
			$statusId = $status->id;
			
			if ($data['status']['new'] == 'nojob_review' && !empty($data['nojob_data']['option'])) {
				
				$nojob      = Nojob::find($data['nojob_data']['option']);
				$assignment = $this->find($assignmentId);
				$tags       = !empty($assignment->tags) ? collect($assignment->tags)->pluck('id')->all() : [];
				
				if ($nojob->nojob == 'Y') {
					Note::create([
						'text'         => $nojob->text,
						'notable_id'   => $assignment->id,
						'created_by'   => $employeeId,
						'type'         => 'no_job',
						'notable_type' => 'Modules\Assignments\Entities\Assignment',
					]);
					
					if (in_array($nojob->id, [3, 4, 5, 6]) && in_array(4, $tags)) {
						$statusId = 8;
					} else {
						$statusId = $nojob->status_id;
						
						$statusDB = AssignmentsStatus::find($nojob->status_id);
						
						Note::create([
							'text'         => "### CHANGE STATUS TO: $statusDB->name ### PLEASE BILL TRIP CHARGE",
							'notable_id'   => $assignment->id,
							'created_by'   => $employeeId,
							'type'         => 'assignment',
							'notable_type' => 'Modules\Assignments\Entities\Assignment',
						]);
						
						Note::create([
							'text'         => "### CHANGE STATUS TO: $statusDB->name ### PLEASE BILL TRIP CHARGE",
							'notable_id'   => $assignment->id,
							'created_by'   => $employeeId,
							'type'         => 'finance',
							'notable_type' => 'Modules\Assignments\Entities\Assignment',
						]);
					}
				} else {
					$text     = '';
					$statusId = $nojob->status_id;
					$statusDB = AssignmentsStatus::find($nojob->status_id);
					
					if (in_array($statusId, [11, 12, 27])) {
						if ($assignment->scheduling) {
							$assignment->scheduling->delete();
						}
					}
					
					Note::create([
						'text'         => "### CHANGE STATUS TO: $statusDB->name ### $nojob->text",
						'notable_id'   => $assignment->id,
						'created_by'   => $employeeId,
						'type'         => 'assignment',
						'notable_type' => 'Modules\Assignments\Entities\Assignment',
					]);
				}
			}
			
			if ($data['status']['new'] == 'uploading_pics' && $data['job_type'] == 'TREE 3RD') {
				$statusId = 48;
			}
			
			return [
				'status_id' => $statusId,
			];
		}
		
		public function getData()
		{
			
			$address = [
				'street'  => $this->street,
				'city'    => $this->city,
				'state'   => $this->state,
				'zipcode' => $this->zipcode,
			];
			if ($this->scheduling) {
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
			
			if ($this->phones) {
				$info_phones = "";
				$count       = 0;
				foreach ($this->phones as $phone) {
					if ($count == 0) {
						$info_phones = "$phone->phone";
					} else {
						$info_phones = "$info_phones - $phone->phone";
					}
					$count++;
				}
			} else {
				$info_phones = NULL;
			}
			$notes = "";
			
			$notesTech = Note::where('notable_id', $this->id)->where('type', 'tech')->get();
			
			if (count($notesTech) > 0) {
				foreach ($notesTech as $nota) {
					$user  = $nota->user->name;
					$notes = $notes."$nota->text - ($user - $nota->created_datetime)\n";
				}
			}
			
			$count_auth = count($this->authorizations);
			
			if ($this->auth_needed == 'N') {
				$count_auth = 0;
			} else {
				$count_auth = 1;
			}
			
			$event = "";
			if ($this->event) {
				$event = $this->event->name;
			}
			
			switch ($this->status_id) {
				case 3:
				case 2:
				case 15:
					$status = $this->status->name;
					break;
				default:
					$status = 'delete';
					break;
			}
			
			$jobTypes = $this->checkJobType($this->job_types);
/*			$job_type = collect($this->job_types)->pluck('name');*/
			
			$tags = !empty($this->tags) ? collect($this->tags)->pluck('name')->unique()->values()->all() : NULL;
			
			$firebase = [
				'job_id'               => $this->id,
				'employee_id'          => $tech_id,
				'employee_name'        => $tech_name,
				'referral_company'     => $this->referral_carrier_full,
				'job_type'             => $jobTypes['job_type'],
				'job_types'            => $jobTypes['job_types'],
				'email'                => $this->email,
				'full_name'            => $this->full_name,
				'full_phone'           => $info_phones,
				'total_authorizations' => $count_auth,
				'docusign_sent'        => FALSE,
				'event'                => $event,
				'nojob'                => NULL,
				'notes'                => $notes,
				'tags'                 => $tags,
				'claim'                => $this->claim_number,
				'adjuster'             => $this->adjuster_info,
				'order'                => (int) $this->status->ordem,
				'created_at'           => $this->date_assignment ?? Carbon::now(),
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
		
		protected function checkJobType($jobTypes)
		{
			$idsToCheck = 18;
			$types      = collect($jobTypes);
			$names      = $types->pluck('name');
			
			$data = $types->contains('id', $idsToCheck)
				? [
					'job_type'  => 'TREE 3RD',
					'job_types' => 'TREE 3RD'
				]
				: [
					'job_type'  => $names->first(),
					'job_types' => $names->implode(', ')
				];
			
			return $data;
		}
		
	}