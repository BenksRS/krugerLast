<div class="e-schedule-container c-timeline-layout"
     data-component="schedule"
     data-scroll-time="{{ $timeline['scroll'] }}">
	
	<div class="e-header-container">
		<div class="e-schedule-slot"></div>
	</div>
	
	<div class="e-header-container" data-scroll-sync="timeline">
		<div class="e-header-wrap">
			<div class="e-header-scope">
				@foreach($timeline['header'] as $data)
					<div class="e-schedule-slot"
					     data-time="{{ $data['time'] }}"
					     data-date="{{ $data['datetime'] }}">
						{{ $data['meridiem']['time'] }}
						<span>{{ $data['meridiem']['period'] }}</span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	
	<div class="e-resource-container" data-scroll-sync="timeline">
		<div class="e-resource-wrap">
			<div class="e-resource-scope">
				@foreach($techs as $tech)
					<div class="e-schedule-slot">
						{{ $tech->user->name }}
						<span>{{ $tech->group ?? 'technician' }}</span>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	
	<div class="e-content-container" data-scroll-sync="timeline">
		<div class="e-content-wrap" id="content-dragsource">
			
			<div role="gridcell" class="e-content-time" data-layout="time">
				@foreach($timeline['content'] as $data)
					<div role="presentation"
					     data-slot="{{ $data['slot'] }}"
					     data-time="{{ $data['time'] }}"
					     data-date="{{ $data['datetime'] }}"></div>
				@endforeach
			</div>

			<div role="gridcell" class="e-content-resource">
				@foreach($techs as $tech)
					<div role="presentation" class="e-content-events"
						 wire:key="tech-{{ $tech->id }}"
						 data-tech="{{ $tech->id }}"
						 data-layout="event">

						@foreach($schedulling->where('tech_id', $tech->id) as $schedule)
							<div class="e-event"
								 wire:key="scheduling-{{$schedule->id }}"
								 wire:ignore.self
								 data-assignment_id="{{ $schedule->assignment->id }}"
								 data-dragsource="schedule"
								 style="
									--timeline-event-start: {{ $schedule->timeline['start']['slot'] }};
									--timeline-event-end: {{ $schedule->timeline['end']['slot'] }}">

								<div class="e-event-data alert {{$schedule->assignment->last_status->class}}">
									<div class="row">
										<div class="col-lg-12">
											#{{ $schedule->assignment->id }}
										</div>
										<div class="col-lg-12" style="font-size: 8px">
											{{$schedule->assignment->city}} - {{$schedule->assignment->state}}
										</div>
										<div class="col-lg-12" style="font-size: 9px">
											@foreach($schedule->assignment->job_types as $job_types)
												<?php $count=0;$count++;?>
												@if($count == 1)
													{{$job_types->name}}
												@else
													{{" / $job_types->name"}}
												@endif
											@endforeach
										</div>

									</div>

								</div>

							</div>
						@endforeach
					</div>
				@endforeach
			</div>
		
		</div>
	</div>
</div>


