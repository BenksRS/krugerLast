<div>
  <div class="card">
	<div class="card-body">
	  <form class="row flex-xl-row flex-column align-items-center justify-content-end">
		<div class="col-sm-3" wire:ignore>
		  <select class=" form-control select2-multiple"
				  name="filters.user_id" wire:model.defer="filters.user_id" data-placeholder="Techs">
			<option selected>Techs</option>
			@foreach($techs as $tech)
			  <option value="{{$tech->id}}">{{$tech->name}}</option>
			@endforeach
		  </select>
		</div>
		<div class="col-sm-auto hstack">
		  <div class="vr"></div>
		</div>
		<div class="col-sm-3" wire:ignore>
		  <select class=" form-control select2-multiple"
				  name="filters.status" wire:model.defer="filters.status" data-placeholder="Status">
			<option selected>Status</option>
			@foreach($status as $key => $data)
			  <option value="{{$key}}">{{$data}}</option>
			@endforeach
		  </select>
		</div>
		<div class="col-sm-auto hstack">
		  <div class="vr"></div>
		</div>
		<div class="col-sm-3" wire:ignore>
		  <select class=" form-control select2-multiple"
				  name="filters.job_type" wire:model.defer="filters.job_type" data-placeholder="Job Types">
			<option selected>Job Type</option>
			@foreach($jobTypes as $jobType)
			  <option value="{{$jobType->id}}">{{$jobType->name}}</option>
			@endforeach
		  </select>
		</div>
		<div class="col-sm-auto hstack">
		  <div class="vr"></div>
		</div>
		<div class="col-sm-auto">
		  <button class="btn btn-primary w-md" wire:loading.attr="disabled" wire:click.prevent="submit" wire:target="submit">
			<i class="bx bx-search"></i> Filter
		  </button>
		</div>
	  </form>
	</div>
  </div>

  <div wire:loading.flex>
	.....
  </div>

  <div class="row" wire:loading.remove>
	<div class="col-12">
	  <div class="card">
		<div class="card-header bg-transparent border-bottom text-uppercase px-4 py-3"></div>
		<div class="card-body overflow-auto" data-scroll-sync>
		  <div class="table-responsive">
			<table class="table table-bordered table-nowrap align-middle accordion table-accordion">
			  <thead>
				<tr>
				  <th scope="col" width="50px"></th>
				  <th scope="col" width="100px" class="text-center">ID</th>
				  <th scope="col">Employee</th>
				  <th scope="col" width="150px" class="text-center">Total Jobs</th>
				  <th scope="col" width="150px" class="text-end">Pending</th>
				  <th scope="col" width="150px" class="text-end">Available</th>
				  <th scope="col" width="150px" class="text-end">Paid</th>
				  <th scope="col" width="150px" class="text-end">Total</th>
				</tr>
			  </thead>
			  <tbody>
				@forelse($listData as $key => $list)
				  <tr>
					<td class="text-center" data-bs-toggle="collapse" data-bs-target="#r{{ $key }}" style="cursor: pointer; max-width: 50px; width: 50px">
					  <i class="fas fa-plus"></i>
					</td>
					<td class="text-center"><p class="mb-0">{{ $key }}</p></td>
					<td><p class="mb-0">{{ $techs->firstWhere('id', $key)->name ?? '' }}</p></td>
					<td class="text-center"><p class="mb-0">{{ $list['assignments']->count() ?? 0 }}</p></td>
					<td class="text-end"><p class="mb-0">${{ $list['commissions']['pending'] ?? 0 }}</p></td>
					<td class="text-end"><p class="mb-0">${{ $list['commissions']['available'] ?? 0 }}</p></td>
					<td class="text-end"><p class="mb-0">${{ $list['commissions']['paid'] ?? 0 }}</p></td>
					<td class="text-end"><p class="mb-0">${{ $list['commissions']['total'] ?? 0 }}</p></td>
				  </tr>
				  @if(!empty($list['assignments']))
					<tr>
					  <td colspan="8">
						<div class="table-responsive collapse accordion-collapse {{ $loop->first ? 'show' : '' }}"
							 id="r{{ $key }}" data-bs-parent=".table-accordion">
						  <table class="table table-bordered table-nowrap align-middle mb-0">
							<thead>
							  <tr style="background-color:#f9f9f9;">
								<th width="150px" class="text-center">ID</th>
								<th width="150px" class="text-center">Assignment ID</th>
								<th>Description</th>
								<th width="150px" class="text-center">Status</th>
								<th width="150px" class="text-end">Amount</th>
								<th width="150px" class="text-center">Comission Month</th>
							  </tr>
							</thead>
							<tbody>
							  @foreach($list['assignments'] as $data)
								<tr>
								  <td class="text-center">{{ $data['id'] }}</td>
								  <td class="text-center">{{ $data['assignment_id'] }}</td>
								  <td>{{ $jobTypes->firstWhere('id', $data['job_type'])->name }} - ${{ $data['amount'] }}</td>
								  <td class="text-center">
									<span class="badge text-uppercase {{ $data['status'] }}" style="display: block; line-height: normal; padding: 7px">{{ $data['status'] }}</span>
								  </td>
								  <td class="text-end" >${{ $data['amount'] }}</td>
								  <td class="text-center">{{ $data['due_month'] }}/{{ $data['due_year'] }}</td>
								</tr>
							  @endforeach
							</tbody>
						  </table>
						</div>
					  </td>
					</tr>
				  @endif
				@empty
				  <tr>
					<td colspan="8" class="text-center">No data</td>
				  </tr>
				@endforelse
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>