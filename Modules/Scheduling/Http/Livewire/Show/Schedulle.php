<?php
	
	namespace Modules\Scheduling\Http\Livewire\Show;
	
	use Carbon\Carbon;
	use Livewire\Component;
	use Modules\Assignments\Entities\Assignment;
	use Modules\Assignments\Entities\AssignmentsScheduling;
	use Modules\Assignments\Entities\AssignmentsStatus;
	use Modules\Assignments\Entities\AssignmentsStatusPivot;
	use Modules\Assignments\Repositories\AssignmentRepository;
	use Modules\Notes\Entities\Directions;
	use Modules\User\Entities\Techs;
	use DateTime;
	use Auth;
	
	class Schedulle extends Component {
		
		protected $listeners    = [
			'setFilter',
			'changeRoute',
			'nullFilter'
		];
		
		public    $techs;
		
		public    $schedulled;
		
		public    $systemSchedulled;
		
		public    $grids        = [];
		
		public    $grids_header = [];
		
		public    $date;
		
		public    $dateDisplay;
		
		public    $weekDisplay;
		
		public    $openJobs;
		
		public    $showSystem   = FALSE;
		
		public    $openJobsCity;
		
		public    $systemJobsCity;
		
		public    $newJobsCity;
		
		public    $totalJobs;
		
		public    $user;
		
		public    $jobRoute;
		
		public    $filter;
		
		public    $filterSystem;
		
		public    $addresses;
		
		public    $originAddress;
		
		public    $statusList;
		
		public    $checklist    = [1  => TRUE, 11 => TRUE, 12 => FALSE, 17 => TRUE, 28 => FALSE, 34 => TRUE, 35 => TRUE, 37 => FALSE, 38 => FALSE, 39 => FALSE, 40 => FALSE, 41 => FALSE, 43 => FALSE, 45 => TRUE, 46 => TRUE,];
		
		public function mount ()
		{
			
			//        dd($this->getChecklist(true));
			$this->techs       = Techs::with('user')->where('active', 'Y')->whereNotIn('id', [73])->orderBy('order')->get();
			$this->date        = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('Y-m-d');
			$this->dateDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('F d, Y');
			$this->weekDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('l');
			$this->statusList  = AssignmentsStatus::whereIn('id', $this->getChecklist())->get();
			$this->user        = Auth::user();
			
			$this->dateJobs();
			$this->setAddresses();
			
			//        $this->getOpenJobsCity();
			//
			////        dd($this->originAddress);
			///

			
		}
		
		public function updated ($field)
		{
			
			switch ( $field ) {
				case 'checklist.1':
				case 'checklist.11':
				case 'checklist.12':
				case 'checklist.17':
				case 'checklist.27':
				case 'checklist.28':
				case 'checklist.14':
				case 'checklist.29':
				case 'checklist.31':
				case 'checklist.32':
				case 'checklist.34':
				case 'checklist.35':
				case 'checklist.36':
				case 'checklist.37':
				case 'checklist.38':
				case 'checklist.39':
					$this->checkFilter();
					break;
				default:
					break;
			}
		}
		
		protected function getChecklist ($filter = FALSE)
		{
			return array_keys($filter ? array_filter($this->checklist) : $this->checklist);
		}
		
		public function toogleSystem ()
		{
			$this->showSystem = !$this->showSystem;
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function checkFilter ()
		{
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function nullFilter ()
		{
			$this->filter = NULL;
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function setFilter ($labelSelected)
		{
			$this->filter = $labelSelected;
			
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function getOpenJobsCity ()
		{
			$jobs = AssignmentRepository::whereIn('status_id', $this->getChecklist(TRUE))->get();
			
			$this->totalJobs = count($jobs);
			$jobsbyState     = $jobs->groupBy('state');
			
			if ( count($jobsbyState) > 0 ) {
				
				foreach ( $jobsbyState as $state => $jobsState ) {
					
					foreach ( $jobsState->groupBy('city') as $city => $jobs ) {
						//                dd($jobs);
						$total       = count($jobs);
						$destination = "$city, $state, US";
						$label       = "$state - $city";
						
						//                dd($this->originAddress);
						if ( $this->originAddress ) {
							
							$milhas       = $this->getMiles($this->originAddress, $destination);
							$milhas_text  = $milhas->text;
							$milhas_value = $milhas->value;
							//
							//                    $milhas_text='-';
							//                    $milhas_value=0;
						} else {
							$milhas_text  = '-';
							$milhas_value = 0;
						}
						
						$slug   = strtolower(str_replace(' ', '', $label));
						$slug   = strtolower(str_replace(',', '', $slug));
						$coll[] = (object) [
							'id'     => rand(1, 10000000),
							'total'  => $total,
							'slug'   => $slug,
							//                    'jobs' => $jobs,
							'label'  => $label,
							'city'   => $city,
							'state'  => $state,
							'milhas' => $milhas_text,
							'order'  => $milhas_value
						];
					}
				}
				$coll = collect($coll);
			} else {
				$coll = [];
			}
			
			$this->openJobsCity = $coll;
		}
		
		public function getSystemJobsCity ()
		{
			// $jobs = AssignmentRepository::whereIn('status_id',$this->getChecklist(TRUE))->get();
			$tech_system = 73;
			$jobs        = AssignmentRepository::SchedulledSystem($this->date, $tech_system)->get();
			
			//        dd($jobs);
			
			$this->totalJobs = count($jobs);
			$jobsbyState     = $jobs->groupBy('state');
			
			if ( count($jobsbyState) > 0 ) {
				
				foreach ( $jobsbyState as $state => $jobsState ) {
					
					foreach ( $jobsState->groupBy('city') as $city => $jobs ) {
						//                dd($jobs);
						$total       = count($jobs);
						$destination = "$city, $state, US";
						$label       = "$state - $city";
						
						//                dd($this->originAddress);
						if ( $this->originAddress ) {
							
							$milhas       = $this->getMiles($this->originAddress, $destination);
							$milhas_text  = $milhas->text;
							$milhas_value = $milhas->value;
							//
							//                    $milhas_text='-';
							//                    $milhas_value=0;
						} else {
							$milhas_text  = '-';
							$milhas_value = 0;
						}
						
						$slug   = strtolower(str_replace(' ', '', $label));
						$slug   = strtolower(str_replace(',', '', $slug));
						$coll[] = (object) [
							'id'     => rand(1, 10000000),
							'total'  => $total,
							'slug'   => $slug,
							//                    'jobs' => $jobs,
							'label'  => $label,
							'city'   => $city,
							'state'  => $state,
							'milhas' => $milhas_text,
							'order'  => $milhas_value
						];
					}
				}
				$coll = collect($coll);
			} else {
				$coll = [];
			}
			
			$this->systemJobsCity = $coll;
		}
		
		public function getNewJobs ()
		{
			$jobs = AssignmentRepository::whereIn('status_id', $this->getChecklist(TRUE))->get();
			
			//        dd($jobs);
			
			$this->totalJobs = count($jobs);
			$jobsbyState     = $jobs->groupBy('state');
			
			if ( count($jobsbyState) > 0 ) {
				
				foreach ( $jobsbyState as $state => $jobsState ) {
					
					foreach ( $jobsState->groupBy('city') as $city => $jobs ) {
						//                dd($jobs);
						$total       = count($jobs);
						$destination = "$city, $state, US";
						$label       = "$state - $city";
						
						//                dd($this->originAddress);
						if ( $this->originAddress ) {
							
							$milhas       = $this->getMiles($this->originAddress, $destination);
							$milhas_text  = $milhas->text;
							$milhas_value = $milhas->value;
							//
							//                    $milhas_text='-';
							//                    $milhas_value=0;
						} else {
							$milhas_text  = '-';
							$milhas_value = 0;
						}
						
						$slug   = strtolower(str_replace(' ', '', $label));
						$slug   = strtolower(str_replace(',', '', $slug));
						$coll[] = (object) [
							'id'     => rand(1, 10000000),
							'total'  => $total,
							'slug'   => $slug,
							//                    'jobs' => $jobs,
							'label'  => $label,
							'city'   => $city,
							'state'  => $state,
							'milhas' => $milhas_text,
							'order'  => $milhas_value
						];
					}
				}
				$coll = collect($coll);
			} else {
				$coll = [];
			}
			
			$this->newJobsCity = $coll;
		}
		
		public function getReferralName ($referral, $carrier)
		{
			
			if ( strlen($referral) > 10 ) {
				$referral = substr($referral, 0, 10) . '';
			}
			if ( strlen($carrier) > 10 ) {
				$carrier = substr($carrier, 0, 10) . '';
			}
			
			$name = "$referral / $carrier";
			
			return $name;
		}
		
		public function getOpenJobs ($city, $state)
		{
			//dd($city - $state);
			$jobs = Assignment::with(['status', 'referral', 'carrier', 'phones'])
			                  ->whereIn('status_id', $this->getChecklist(TRUE))
			                  ->where('city', $city)
			                  ->where('state', $state)
			                  ->get();
			if ( count($jobs) > 0 ) {
				foreach ( $jobs as $job ) {
					//dd("$this->originAddress, $job->originAddress");
					$destination = sprintf("%s, %s, %s %s", ucwords(strtolower($job->street)), ucwords(strtolower($job->city)), $job->state, $job->zipcode);
					
					$milhas       = $this->getMiles($this->originAddress, $destination);
					$milhas_text  = $milhas->text;
					$milhas_value = $milhas->value;
					
					//                $milhas_text='-';
					//                $milhas_value=0;
					
					$coll[] = (object) [
						'id'          => $job->id,
						'job'         => $job,
						'destination' => $job->originAddress,
						'milhas'      => $milhas_text,
						'order'       => $milhas_value
					];
				}
				
				$coll = collect($coll);
			} else {
				$coll = [];
			}
			
			return $coll;
		}
		
		public function getNewOpenJobs ()
		{
			//dd($city - $state);
			$jobs = Assignment::with(['status', 'referral', 'carrier', 'phones'])
			                  ->whereIn('status_id', $this->getChecklist(TRUE))
			                  ->get();
			if ( count($jobs) > 0 ) {
				foreach ( $jobs as $job ) {
					//dd("$this->originAddress, $job->originAddress");
					$destination = sprintf("%s, %s, %s %s", ucwords(strtolower($job->street)), ucwords(strtolower($job->city)), $job->state, $job->zipcode);
					
					$milhas       = $this->getMiles($this->originAddress, $destination);
					$milhas_text  = $milhas->text;
					$milhas_value = $milhas->value;
					
					//                $milhas_text='-';
					//                $milhas_value=0;
					
					$coll[] = (object) [
						'id'          => $job->id,
						'job'         => $job,
						'destination' => $job->originAddress,
						'milhas'      => $milhas_text,
						'order'       => $milhas_value
					];
				}
				
				$coll = collect($coll);
			} else {
				$coll = [];
			}
			
			return $coll;
		}
		
		public function getSystemJobs ()
		{
			$tech_system = 73;
			$jobs        = AssignmentRepository::SchedulledSystem($this->date, $tech_system)
			                                   ->get();
			if ( count($jobs) > 0 ) {
				foreach ( $jobs as $job ) {
					//dd("$this->originAddress, $job->originAddress");
					$destination = sprintf("%s, %s, %s %s", ucwords(strtolower($job->street)), ucwords(strtolower($job->city)), $job->state, $job->zipcode);
					
					$milhas       = $this->getMiles($this->originAddress, $destination);
					$milhas_text  = $milhas->text;
					$milhas_value = $milhas->value;
					
					//                $milhas_text='-';
					//                $milhas_value=0;
					
					$coll[] = (object) [
						'id'          => $job->id,
						'job'         => $job,
						'destination' => $destination,
						'milhas'      => $milhas_text,
						'order'       => $milhas_value
					];
				}
				
				$coll = collect($coll);
			} else {
				$coll = [];
			}
			
			return $coll;
		}
		
		public function changeRoute ($origin)
		{
			
			//        dd($origin);
			$this->originAddress = $origin[0];
			$this->jobRoute      = $origin[1];
			//        $this->dateJobs();
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function getMiles ($originAddress, $destinationAddress)
		{
			
			//        dd($originAddress)
			$direction = Directions::where('origin', $originAddress)->where('destination', $destinationAddress)->first();
			
			if ( !$direction ) {
				$address = google_distance($originAddress, $destinationAddress);
				$explode = explode(' ', $address);
				$milhas  = explode('.', $explode[0]);
				
				$numero    = str_replace(',', '', $milhas[0]);
				$numero    = (int) $numero;
				$direction = (object) [
					'value' => $numero,
					'text'  => $address
				];
				$insert    = [
					'origin'      => $originAddress,
					'destination' => $destinationAddress,
					'text'        => $address,
					'value'       => $numero
				];
				Directions::create($insert);
				
				return $direction;
			} else {
				return $direction;
			}
		}
		
		public function dateJobs ()
		{
			$this->schedulled = AssignmentsScheduling::with('assignment')->whereDate('start_date', $this->date)->get();
			$tech_system      = 73;
			//        $this->systemSchedulled = AssignmentsScheduling::with('assignment')->where('tech_id', $tech_system)->whereDate('start_date', $this->date)->get();
		}
		
		public function reloadGridJobs ()
		{
			
			$this->run_grids();
			$this->run_grids_header();
		}
		
		public function changeDate ($action)
		{
			$modify = $action == 'prev' ? '-1' : '+1';
			$this->setDate($modify);
		}
		
		protected function setDate ($modify = NULL)
		{
			$dateTime = new DateTime($this->date);
			if ( $modify ) {
				$dateTime->modify("$modify day");
			}
			$this->date = $dateTime;
			
			$this->date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($this->date))->format('Y-m-d');
			
			$this->dateDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('F d, Y');
			$this->weekDisplay = Carbon::createFromFormat('Y-m-d', $this->date)->format('l');
			$this->dateJobs();
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
			$this->reloadGridJobs();
			//        dd( $this->date);
		}
		
		public function checkTimeframeforTech ($tech_id, $start_date)
		{
			$check = AssignmentsScheduling::where('tech_id', $tech_id)
			                              ->where('end_date', '>', $start_date)
			                              ->where('start_date', '<=', $start_date)->get();
			
			if ( count($check) > 0 ) {
				
				return FALSE;
			} else {
				//            dd('TRUE dsdssd');
				return TRUE;
			}
		}
		
		public function alacrityVisitPlanned ($id, $date)
		{
			
			$job = Assignment::find($id);
			
			if ( $job->referral->id == 24 ) {
				
				// alacrity time zone
				switch ( $job->state ) {
					case 'LA':
						$ContactDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->subHours(1)->format('Y-m-d H:i:s');
						break;
					default:
						$ContactDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
						break;
				}
				
				alacrity_service()->post('UpdateDates', ['AssignmentId' => $job->allacrity_id],
					[
						"AssignmentDates" => [
							'ScheduledVisitDate' => $ContactDate
						]
					]);
				
				$this->emit('contentCC');
			}
		}
		
		public function schedulleJobs ($JobsReturn)
		{
			//        dd($JobsReturn);
			$message       = "";
			$message_error = "";
			foreach ( $JobsReturn as $jobs ) {
				if ( $jobs['value'] != 'openJobs' ) {
					
					$infos      = explode('_', $jobs['value']);
					$tech_id    = $infos[1];
					$start_date = $infos[3];
					
					foreach ( $jobs['items'] as $item ) {
						$assignment_id = $item['value'];
						
						$jobSched = AssignmentsScheduling::where('assignment_id', $assignment_id)->first();
						
						if ( $jobSched ) {
							if ( $jobSched->tech_id == 73 ) {
								$start_date = $jobSched->start_date;
							}
						}
						
						//                    $end_date = new \DateTime($start_date); //now
						$end_date = new \DateTime($start_date); //now
						$end_date->add(new \DateInterval('PT1H'));
						
						$update          = [
							'tech_id'    => $tech_id,
							'start_date' => $start_date,
							'end_date'   => $end_date,
							'updated_by' => $this->user->id,
						];
						$data_start_show = Carbon::parse($start_date)->format('m/d/Y g:i A');
						$data_end_show   = Carbon::parse($end_date)->format('m/d/Y g:i A');
						
						$tech_info = Techs::find($tech_id);
						$tech_name = $tech_info->user->name;
						
						$description = "Scheduled: $data_start_show to $data_end_show - Tech : $tech_name";
						
						if ( $jobSched ) {
							if ( $jobSched->start_date != $start_date || $jobSched->tech_id == 73 ) {
								
								// check if has another
								$checkTimeframe = $this->checkTimeframeforTech($tech_id, $start_date);
								
								if ( $checkTimeframe === TRUE ) {
									$jobSched->update($update);
									$message = "<b>#$assignment_id</b> - Schedulled to $start_date";
									
									// update status in assignment
									$assignment = Assignment::find($assignment_id);
									
									$updateAssignment = [
										'status_id'  => 2,
										'updated_by' => $this->user->id
									];
									$assignment->update($updateAssignment);
									
									// add status in history
									$AssignmentStatus = [
										'assignment_id'        => $assignment_id,
										'assignment_status_id' => 2,
										'created_by'           => $this->user->id,
										'description'          => $description,
									];
									AssignmentsStatusPivot::create($AssignmentStatus);
									
									integration('assignments')->set($assignment_id);
									
									$this->alacrityVisitPlanned($assignment_id, $start_date);
								} else {
									$message_error = "<b>ERROR #$assignment_id</b> - This Technician already have a job at this time!";
								}
							}
						} else {
							// check if has another
							$checkTimeframe = $this->checkTimeframeforTech($tech_id, $start_date);
							
							if ( $checkTimeframe === TRUE ) {
								// create schedulle
								$update['assignment_id'] = $assignment_id;
								$update['created_by']    = $this->user->id;
								$update['updated_by']    = $this->user->id;
								AssignmentsScheduling::create($update)->save();
								// add status in history
								$AssignmentStatus = [
									'assignment_id'        => $assignment_id,
									'assignment_status_id' => 2,
									'created_by'           => $this->user->id,
									'description'          => $description,
								];
								AssignmentsStatusPivot::create($AssignmentStatus);
								
								// update status in assignment
								$assignment = Assignment::find($assignment_id);
								
								$updateAssignment = [
									'status_id'  => 2,
									'updated_by' => $this->user->id
								];
								$assignment->update($updateAssignment);
								
								integration('assignments')->set($assignment_id);
								
								$this->alacrityVisitPlanned($assignment_id, $start_date);
								
								$message = "<b>#$assignment_id</b> - Schedulled to $start_date";
							} else {
								$message_error = "<b>ERROR #$assignment_id</b> - This Technician already have a job at this time!";
							}
						}
						if ( $message_error ) {
							session()->flash('schederror', [
								'class'   => 'danger',
								'message' => $message_error
							]);
						}
						if ( $message ) {
							session()->flash('schedupdate', [
								'class'   => 'success',
								'message' => $message
							]);
						}
					}
				}
			}
			
			$this->reloadGridJobs();
			$this->dateJobs();
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function run_grids_header ()
		{
			$interval               = ['AM', 'PM'];
			$j                      = 0;
			$this->grids_header[$j] = (object) [
				'time'   => '12:00',
				'format' => 'AM'
			];
			for ( $i = 1; $i <= 11; $i ++ ) {
				$j ++;
				if ( $i < 10 ) {
					$result                 = "0$i:00";
					$this->grids_header[$j] = (object) [
						'time'   => $result,
						'format' => 'AM'
					];
				} else {
					$result                 = "$i:00";
					$this->grids_header[$j] = (object) [
						'time'   => $result,
						'format' => 'AM'
					];
				}
			}
			$j ++;
			$this->grids_header[$j] = (object) [
				'time'   => '12:00',
				'format' => 'PM'
			];
			for ( $i = 1; $i <= 11; $i ++ ) {
				$j ++;
				if ( $i < 10 ) {
					$result                 = "0$i:00";
					$this->grids_header[$j] = (object) [
						'time'   => $result,
						'format' => 'PM'
					];
				} else {
					$result                 = "$i:00";
					$this->grids_header[$j] = (object) [
						'time'   => $result,
						'format' => 'PM'
					];
				}
			}
		}
		
		public function run_grids ()
		{
			$interval = ['00', '30'];
			$j        = 0;
			for ( $i = 0; $i <= 23; $i ++ ) {
				if ( $i < 10 ) {
					foreach ( $interval as $inter ) {
						$result          = "$this->date 0$i:$inter:00";
						$this->grids[$j] = $result;
						$j ++;
					}
				} else {
					foreach ( $interval as $inter ) {
						$result          = "$this->date $i:$inter:00";
						$this->grids[$j] = $result;
						$j ++;
					}
				}
			}
		}
		
		public function changeAddress ($id)
		{
			if ( $id ) {
				$this->setAddresses('id', $id);
			}
		}
		
		protected function setAddresses ($key = 'default', $value = TRUE)
		{
			$all = collect(_timeline('addresses'));
			
			$this->addresses     = [
				'all'      => $all,
				'selected' => $all->firstWhere($key, $value),
			];
			$selected            = (object) $this->addresses['selected'];
			$this->jobRoute      = $selected->id;
			$this->originAddress = "$selected->street , $selected->city, $selected->state $selected->zipcode, US";
			
			$this->reloadGridJobs();
			$this->getOpenJobsCity();
			$this->getSystemJobsCity();
		}
		
		public function render ()
		{
			$this->reloadGridJobs();
			
			return view('scheduling::livewire.show.schedulle', [
				'list_schedulleds'  => $this->schedulled,
				'list_openJobsCity' => $this->openJobsCity,
				'list_systemCity'   => $this->systemJobsCity,
				'list_newJobs'      => $this->newJobsCity,
			]);
		}
		
	}
