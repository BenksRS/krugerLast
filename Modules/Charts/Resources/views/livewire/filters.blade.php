<div>
	<div class="card">
		<div class="card-body">
			
			<form class="row flex-xl-row flex-column align-items-center justify-content-end">
				<div class="col-sm-3" wire:ignore>
				  <select class="form-control select-state select2 select2-multiple" multiple data-placelholder="Select State..." id="filter_state" name="filters.state" wire:model.defer="filters.state">
					<option value="AL">AL</option>
					<option value="FL">FL</option>
					<option value="LA">LA</option>
					<option value="MS">MS</option>
					<option value="NC">NC</option>
					<option value="SC">SC</option>
					<option value="TX">TX</option>
					<option value="GA">GA</option>
				  </select>
				</div>
			  <div class="col-sm-auto hstack">
				<div class="vr"></div>
			  </div>
				@foreach($fields as $key => $field)
					<div class="col-sm-auto">
						@switch($field['type'])
							
							@case('daterange')
								<div class="input-daterange input-group" id="datepicker_{{ $field['name'] }}" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker_{{ $field['name'] }}'>
									@foreach($field['input'] as $name => $value)
										<input type="text" class="form-control" autocomplete="off"
										       id="filter_{{ $field['name'] }}_{{ $name }}"
										       placeholder="{{ $value }}"
										       name="filters.{{ $field['name'] }}.{{ $name }}">
									@endforeach
								</div>
								@break
							
							@case('radio')
							@case('checkbox')
								@foreach($field['input'] as $name => $value)
									<div class="form-check form-check-inline">
										
										<input type="{{ $field['type'] }}" class="form-check-input"
										       id="filter_{{ $field['name'] }}_{{ $name }}"
										       value="{{ $name }}"
										       name="filters.{{ $field['name'] }}"
										       wire:model.defer="filters.{{ $field['name'] }}">
										
										<label class="form-check-label"
										       for="filter_{{ $field['name'] }}_{{ $name }}">{{ $value }}
										</label>
									
									</div>
								@endforeach
								@break
						
						@endswitch
					</div>
					
					<div class="col-sm-auto hstack">
						<div class="vr"></div>
					</div>
				@endforeach
				
				<div class="col-sm-auto">
					<button class="btn btn-primary w-md" wire:loading.attr="disabled" wire:click.prevent="submit" wire:target="submit">
						<i class="bx bx-search"></i> Filter
					</button>
				</div>
			
			</form>
		</div>
	</div>
</div>

@push('js')
	<script>
        document.addEventListener('livewire:load', function () {
            $('.input-daterange').datepicker({
                format: 'dd M, yyyy',
            }).on('changeDate', function (e) {
                let date = e.date.toISOString().split('T')[0]
                let name = e.target.name;
                /*             let date = e.format();*/
                if (!name || !date) return;
				
				@this.set(`${ name }`, date, true);
            });

            $('.select-state').on('change', function () {
                let data = $(this).val();
            @this.set('filters.state', data, true);
            })

        })

	</script>
@endpush


