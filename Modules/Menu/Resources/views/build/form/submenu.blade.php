<div class="row">
	<div class="col-md-6">
		<label for="inputTitleSub" class="form-label">Title</label>
		<input type="text" class="form-control" id="inputTitleSub" value="{{ $child->title ?? '' }}">
	</div>
	<div class="col-md-6">
		<label for="inputOpenSub" class="form-label">Open Link in</label>
		<div>
			<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
				<input type="radio" class="btn-check" name="open-in" id="open-in-sub1" autocomplete="off" checked>
				<label class="btn btn-outline-primary" for="open-in-sub1">New Tab</label>
				
				<input type="radio" class="btn-check" name="open-in" id="open-in-sub2" autocomplete="off">
				<label class="btn btn-outline-primary" for="open-in-sub2">Same Tab</label>
			
			</div>
		</div>
	</div>
</div>

<div class="d-flex flex-column mt-4">
	<div class="border w-100 p-4">
		<div class="row">
			<div class="col-md-12">
				<label for="inputUrlSub" class="form-label">URL</label>
				<input type="text" class="form-control" id="inputUrlSub" value="{{ $child->url ?? '' }}">
			</div>
		</div>
	</div>
	
	<div class="ms-auto mt-4">
		<button type="button" class="btn btn-primary waves-effect waves-light">
			<i class="mdi mdi-check me-1"></i> Save changes
		</button>
	</div>
	
</div>