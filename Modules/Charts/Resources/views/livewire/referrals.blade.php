<div>
	<style>
		.datepicker > div {
			display : block;
		}
	</style>
	<div class="row">
		
		<div class="col-12">
			@livewire('charts::filters', key('charts-filters'))
		</div>
		
		<div class="col-12 col-xxl-5">
			<div class="card">
				<div class="card-header bg-transparent border-bottom text-uppercase px-4 py-3 d-none">A</div>
				<div class="card-body">
					<div class="m-auto py-2" style="width: 400px">
						<canvas id="myChart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-xxl-7">
			<div class="card">
				<div class="card-header bg-transparent border-bottom text-uppercase px-4 py-3">Total: {{ $listData->sum('total') ?? '0' }}</div>
				<div class="card-body overflow-auto" data-scroll-sync style="max-height: 800px">
					<div class="table-responsive">
						<table class="table table-bordered align-middle table-nowrap">
							<thead>
								<tr>
									<th scope="col">Referral</th>
									<th scope="col" class="text-center">Total Jobs</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								@forelse($listData->sortByDesc('total') as $list)
									<tr>
										<td style="width: 600px; max-width:600px">
											<p class="mb-0 text-truncate" style="max-width: 600px;" title="{{ $list['name'] }}">{{ $list['name'] }}</p>
										</td>
										<td style="max-width: 120px; width: 120px" class="text-center">
											<p class="mb-0">{{ $list['total'] }}</p>
										</td>
										<td>
											<div class="progress">
												<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $list['percent'] }}%" aria-valuenow="{{ $list['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="3" class="text-center">No data</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	@push('js')
		<script>
            document.addEventListener('livewire:load', function () {
                const ctx   = document.getElementById('myChart');
                const chart = new Chart(ctx, {
                    type:    'pie',
                    data:    {},
                    options: {
                        plugins: {
                            legend:  {
                                display:  false,
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label (context) {
                                        return context.formattedValue + '%';
                                    },
                                },
                            },

                        },
                    },
                });

                Livewire.on('updateChart', data => {
                    chart.data = data;
                    chart.update();
                });
            });
		</script>
	@endpush
</div>


