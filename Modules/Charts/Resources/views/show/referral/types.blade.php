<div class="table-responsive">
	<table class="table table-bordered table-nowrap align-middle accordion table-accordion">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col">Referral Type</th>
				<th scope="col" class="text-center">Total Jobs</th>
				<th scope="col"></th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($listData->sortByDesc('total') as $key => $list)
				<tr>
					<td class="text-center" data-bs-toggle="collapse" data-bs-target="#r{{ $key }}" style="cursor: pointer; max-width: 50px; width: 50px">
						<i class="fas fa-plus"></i>
					</td>
					<td style="max-width: 500px; width: 500px">
						<p class="mb-0">{{ $list['name'] }}</p>
					</td>
					<td style="max-width: 120px; width: 120px" class="text-center">
						<p class="mb-0">{{ $list['total'] }}</p>
					</td>
					<td style="max-width: 100px; width: 100px" class="text-center">
						<p class="mb-0">{{ $list['percentage'] }}%</p>
					</td>
					<td style="max-width: 250px; width: 250px">
						<div class="d-flex align-items-center">
							<div class="progress progress-xl flex-grow-1">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $list['percentage'] }}%" aria-valuenow="{{ $list['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</td>
				</tr>
				@if(!empty($list['data']))
					<tr>
						<td colspan="5">
							<div class="table-responsive collapse accordion-collapse {{ $loop->first ? 'show' : '' }}"
							     id="r{{ $key }}" data-bs-parent=".table-accordion">
								<table class="table table-bordered table-nowrap align-middle mb-0">
									<tbody>
										@foreach($list['data']->sortByDesc('total') as $data)
											<tr style="background-color:#f9f9f9;">
												<td>{{ $data['name'] }}</td>
												<td class="text-center" style="max-width: 120px; width: 120px">{{ $data['total'] }}</td>
												<td style="max-width: 100px; width: 100px" class="text-center">
													<p class="mb-0">{{ $data['percentage'] }}%</p>
												</td>
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
					<td colspan="5" class="text-center">No data</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>

@push('js')
	<script>
        $(document).ready(function () {

        })
	</script>
@endpush