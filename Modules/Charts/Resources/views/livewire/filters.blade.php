<div>
	<div class="card">
		<div class="card-body">
			
			<form class="row gy-2 gx-3 align-items-center justify-content-end" wire:submit.prevent="filterDate">
				
				<div class="col-sm-auto">
					<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
						<input type="text" class="form-control" placeholder="Start Date" name="start" autocomplete="off" />
						<input type="text" class="form-control" placeholder="End Date" name="end" autocomplete="off"/>
					</div>
				</div>
				
				<div class="col-sm-auto">
					<button class="btn btn-primary w-md">Filter</button>
				</div>
			
			</form>
		</div>
	</div>
	
	@push('js')
		<script>
            document.addEventListener('livewire:load', function () {
                $('.input-daterange').datepicker({
                    format:         'dd M, yyyy',
            }).on('changeDate', function (e) {
                let date = e.date.toISOString().split('T')[0]
                let name = e.target.name;

                if (!name || !date) return;
				
				@this.set('filters.' + name, date)
            });
            })
		</script>
	@endpush

</div>


