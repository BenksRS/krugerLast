<div class="table-responsive">
	<table class="table table-bordered table-nowrap align-middle">
		<thead>
			<tr>
				<th scope="col">Referral</th>
				<th scope="col">Referral Type</th>
				<th scope="col" class="text-center">Total Jobs</th>
				<th scope="col"></th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			@forelse($listData as $list)
				<tr>
					<td style="width: 500px; max-width: 500px">
						<p class="mb-0 text-truncate" style="max-width: 100%;" title="{{ $list['name'] }}">{{ $list['name'] }}</p>
					</td>
					<td style="max-width: 200px; width: 200px">
						<p class="mb-0">{{ $list['referral']['type']['name'] }}</p>
					</td>
					<td style="max-width: 120px; width: 120px" class="text-center">
						<p class="mb-0">{{ $list['total'] }}</p>
					</td>
					<td style="max-width: 100px; width: 100px" class="text-center">
						<p class="mb-0">{{ $list['percentage'] }}%</p>
					</td>
					<td>
						<div class="d-flex align-items-center">
							<div class="progress progress-xl flex-grow-1">
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $list['percentage'] }}%" aria-valuenow="{{ $list['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" class="text-center">No data</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>