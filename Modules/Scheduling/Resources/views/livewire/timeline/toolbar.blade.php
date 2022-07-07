<div class="c-timeline-toolbar">
	<div class="d-flex flex-wrap text-center text-sm-start align-items-center p-4">
		<div class="d-sm-flex flex-wrap gap-2">
			<div class="btn-group" role="group" aria-label="Basic example">
				<button type="button" class="btn btn-primary btn-rounded" wire:click.prevent="changeDate('prev')">
					<i class="calendar-icon ic-arrow-line-left mdi mdi-chevron-left" data-action="move-prev"></i>
				</button>
				<button type="button" class="btn btn-primary btn-rounded" wire:click.prevent="changeDate('next')">
					<i class="calendar-icon ic-arrow-line-right mdi mdi-chevron-right" data-action="move-next"></i>
				</button>
			</div>
		</div>
		<h5 class="m-0 ms-3 fw-bold">{{ $label }}
			<span class="ms-1 text-secondary opacity-50 fw-normal">Today</span>
		</h5>
	</div>
</div>
