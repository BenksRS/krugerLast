<div>

	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-5 col-lg-2">
							<div class="mb-3 mt-2">
								<label class="form-label">From:</label>

								<div class="input-group" id="start_time-input-group" wire:ignore >
									<x-flatpickr   id="date_from" name="date_from" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
									<span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
								</div>
								@error('start_date')
								<div class="invalid-feedback show">
									Please select a valid datetime.
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-5 col-lg-2">
							<div class="mb-3 mt-2">

								<label class="form-label">To:</label>
								<div class="input-group" id="end_time-input-group" wire:ignore>
									<x-flatpickr   id="date_to" name="date_to" show-time :time24hr="false" alt-format="m/d/Y h:i K"    />
									<span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
								</div>
								@error('end_date')
								<div class="invalid-feedback show">
									Please select a valid datetime.
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">

							<div class="mt-0">
								<h5 class="font-size-14 mb-3">Date Filter By:</h5>
								<div class="form-check-inline">
									<input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
									       id="filter_date_c" value="created">
									<label class="form-check-label" for="filter_date_c">
										Jobs Created
									</label>
								</div>
								<div class="form-check-inline mt-1">
									<input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
									       id="filter_date_s" value="schedulled" checked>
									<label class="form-check-label" for="filter_date_s">
										Jobs Scheduled
									</label>
								</div>
								<div class="form-check-inline mt-1">
									<input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
									       id="filter_date_b" value="billed">
									<label class="form-check-label" for="filter_date_b">
										Jobs Billed
									</label>
								</div>
								<div class="form-check-inline mt-1">
									<input class="form-check-input" type="radio" name="tarp_situation" wire:model="filter_date"
									       id="filter_date_p" value="paid">
									<label class="form-check-label" for="filter_date_p">
										Jobs Paid
									</label>
								</div>
								@error('tarp_situation')
								<div class="invalid-feedback show">
									Please select a valid option.
								</div>
								@enderror
							</div>
						</div>
						<div class="col-md-2">

							<div class="mt-0">
								<h5 class="font-size-14 mb-3">Show By:</h5>
								<div class="form-check-inline">
									<input class="form-check-input" type="radio" name="filter_type" wire:model="filter_type"
									       id="filter_type_jobs" value="jobs">
									<label class="form-check-label" for="filter_date_c">
										Jobs
									</label>
								</div>
								<div class="form-check-inline mt-1">
									<input class="form-check-input" type="radio" name="filter_type" wire:model="filter_type"
									       id="filter_type_ref" value="referral" checked>
									<label class="form-check-label" for="filter_type_ref">
										Referral
									</label>
								</div>
								@error('filter_type')
								<div class="invalid-feedback show">
									Please select a valid option.
								</div>
								@enderror
							</div>
						</div>
						<div class="col-md-2 ">
							<button class="btn btn-lg btn-info m-2 " wire:click="$emit('search')"
							        type="submit"><i class="bx bx-search"></i> Search  </button>
						</div>

						<div class="col-md-5 col-lg-5">
							<div class="mb-3" wire:ignore>
								<label class="form-label">Tags</label>
								<a href="#" wire:click="clear('tagsSelected')" onClick="clearTags()" class="float-end">clear</a>
								<select
									class="select2 form-control select2-multiple select_tags"
									name="tagsSelected" wire:model="tagsSelected"
									data-placeholder="Select ..." data-livewire-model="tagsSelected"
									multiple="multiple">
									@foreach($allTags as $tag)

										@if($tag)
											<option value="{{$tag->id}}">{{$tag->name}}</option>
										@else
											<option value="{{$tag->id}}">{{$tag->name}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div wire:loading class="row">
		<div class="spinner-border text-primary " role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>

	<div wire:loading.remove>
		@if($list)
			@livewire('reports::info.finance',['test' =>$list], key('reports_finance'))

			@switch($filter_type)
				@case('jobs')
					@livewire('reports::info.jobs',['test' =>$list], key('reports_jobs'))
					@break
				@case('referral')
					@livewire('reports::info.referrals',['test' =>$list], key('reports_referrals'))
					@break
			@endswitch
		@endif
	</div>

</div>


@push('js')
	<script>
      $(document).ready(function() {
          $('#date_from').on('change.datetimepicker', function (e){
              let data = $(this).val();
          @this.set('date_from', data);
          });
          $('#date_to').on('change.datetimepicker', function (e){
              let data = $(this).val();
          @this.set('date_to', data);
          });
          $('.select2').select2({
              placeholder: "chose..."
          });

          function handleSelectChange(element) {
              let livewireProperty = $(element).data('livewire-model');
              $(element).on('change', function(e) {
                  let data = $(this).val();
              @this.set(livewireProperty, data);
              });
          }

          // Itera sobre todos os elementos que possuem o atributo data-livewire-model
          $('[data-livewire-model]').each(function() {
              handleSelectChange(this);
          });

      });
      function clearReferral(){
          $('.select_referral').empty().trigger('change');
      }
      function clearCarrier(){
          $('.select_carrier').empty().trigger('change');
      }
	</script>
@endpush