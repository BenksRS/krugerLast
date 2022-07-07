<div class="c-timeline-assignment">
	<div class="e-assignment-addresses p-3">
		<div class="hstack gap-3">
			@foreach($addresses['all'] as $address)
				<a href="#"
				   @class([
					   'link-dark user-select-none',
					   'text-info' => $addresses['selected']['id'] == $address['id'],
					])
				   wire:key="address-{{ $address['id'] }}"
				   wire:click="changeAddress({{ $address['id'] }})"><i class="bx bxs-home"></i>{{ $address['name'] }}
				</a>
			@endforeach
		</div>
		
		<div class="hstack mt-3">
			<div>From <span class="fw-semibold">(OFFICE {{ $addresses['selected']['name'] }})</span></div>
		</div>
	
	</div>
	
	<div class="e-assignment-status p-3">
		@foreach($status as $data)
			<div class="form-check form-check-inline user-select-none" wire:key="check-status-{{ $data->id }}">
				<input class="form-check-input" type="checkbox" id="check-status-{{ $data->id }}" wire:model.lazy="checklist.{{ $data->id }}">
				<label class="form-check-label" for="check-status-{{ $data->id }}">
					<div class="{{ $data->class }} badge rounded-pill text-uppercase">
						{{ $data->name }}
					</div>
				</label>
			</div>
		@endforeach
	</div>
	
	<div class="e-assignment-events" data-scroll-sync="assignments">
		<div class="content-wrapper py-2">
			@foreach($assignments as $assignment)
				@dump($assignment->originAddress)
				<div class="e-event" data-assignment="{{ $assignment->id }}" data-dragsource="assignment" wire:key="assignment-{{ $assignment->id }}">
					<div class="e-event-data alert {{ $assignment->lastStatus->class }}">
						{{ $assignment->fullName }}
						<br>{{ collect($assignment->job_types)->implode('name', ', ') }}
						<br>{{ $assignment->city }} - {{ $assignment->state }}
					</div>
				</div>
			@endforeach
		</div>
	</div>
	
	<div class="e-events d-none">
		<div role="row" class="e-events-group" data-template="columns">
			{{--			@foreach($assignments as $assignment)
							<div role="gridcell" class="e-event e-events-slot"
								 data-assignment="{{ $assignment->id }}"
								 data-dragsource="assignment">
								<div class="e-events-data alert {{ $assignment->lastStatus->class }}">
									{{ $assignment->fullName }}
									<br>{{ collect($assignment->job_types)->implode('name', ', ') }}
									<br>{{ $assignment->city }} - {{ $assignment->state }}
								</div>
							</div>
						@endforeach
					--}}
		</div>
	</div>
</div>