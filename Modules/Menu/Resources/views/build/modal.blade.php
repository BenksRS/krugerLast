<div wire:ignore class="modal fade" role="dialog" id="modal-link" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Menu Item</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form wire:submit.prevent="createLink">
				<div class="modal-body">
					
					<div class="row">
						<div class="col-md-6">
							<label for="inputTitle" class="form-label">Title</label>
							<input type="text" class="form-control" id="inputTitle" wire:model="data.title">
						</div>
						<div class="col-md-6">
							<label for="inputIcon" class="form-label">Icon</label>
							<input type="text" class="form-control" id="inputIcon" wire:model="data.icon">
						</div>
					</div>
					
					<div class="d-flex flex-column mt-4">
						<div class="border w-100 p-4">
							<div class="row">
								<div class="col-md-12">
									<label for="inputUrl" class="form-label">URL</label>
									<input type="text" class="form-control" id="inputUrl" wire:model="data.url">
								</div>
								<div class="col-md-12 mt-4">
									<label for="inputOpen" class="form-label">Open Link in</label>
									<div>
										<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
											<input type="radio" class="btn-check" id="open-in1-" name="data.open[]" wire:model.defer="data.open" value="_blank">
											<label class="btn btn-outline-primary" for="open-in1-">New Tab</label>
											
											<input type="radio" class="btn-check" id="open-in2-" name="data.open[]" wire:model.defer="data.open" value="_self">
											<label class="btn btn-outline-primary" for="open-in2-">Same Tab</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
				
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Save changes</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>