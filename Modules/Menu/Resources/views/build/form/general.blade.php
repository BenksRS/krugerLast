<div class="row">
	<div class="col-md-6">
		<label for="inputTitle" class="form-label">Title</label>
		<input type="text" class="form-control" id="inputTitle" wire:model.defer="link.title">
	</div>
	<div class="col-md-6">
		<label for="inputIcon" class="form-label">Icon</label>
		<input type="text" class="form-control" id="inputIcon" wire:model.defer="link.icon">
	</div>
</div>

<div class="d-flex flex-column mt-4">
	<div class="border w-100 p-4">
		<div class="row">
			<div class="col-md-12">
				<label for="inputUrl" class="form-label">URL</label>
				<input type="text" class="form-control" id="inputUrl" wire:model.defer="link.url">
			</div>
			<div class="col-md-12 mt-4">
				<label for="inputOpen" class="form-label">Open Link in</label>
				<div>
					<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
						<input type="radio" class="btn-check" id="open-in1-{{ $link->id }}" name="link.open[{{ $link->id }}]" wire:model.defer="link.open" value="_blank">
						<label class="btn btn-outline-primary" for="open-in1-{{ $link->id }}">New Tab</label>
						
						<input type="radio" class="btn-check" id="open-in2-{{ $link->id }}" name="link.open[{{ $link->id }}]" wire:model.defer="link.open" value="_self">
						<label class="btn btn-outline-primary" for="open-in2-{{ $link->id }}">Same Tab</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="ms-auto mt-4">
		<button type="button" class="btn btn-primary waves-effect waves-light" wire:click="saveLink">
			<i class="mdi mdi-check me-1"></i> Save changes
		</button>
	</div>

</div>