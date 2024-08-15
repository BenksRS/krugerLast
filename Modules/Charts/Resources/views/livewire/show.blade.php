<div>
	<div wire:loading.flex>
		.....
	</div>
	
	<div class="row" wire:loading.remove>
		
		<div class="col-12 col-xxl-5">
			<div class="card">
				<div class="card-header bg-transparent border-bottom text-uppercase px-4 py-3 d-none">A</div>
				<div class="card-body">
					<div class="m-auto py-5" style="width: 400px">
						<canvas id="myChart"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-xxl-7">
			<div class="card">
				<div class="card-header bg-transparent border-bottom text-uppercase px-4 py-3">Total: {{ $listData->sum('total') ?? '0' }}</div>
				<div class="card-body overflow-auto" data-scroll-sync style="max-height: 800px">
					@includeIf($loadData['view'])
				</div>
			</div>
		</div>
	</div>
</div>

@push('css')
	<style>
		.datepicker > div {
			display : block;
		}
		select.form-control {
			appearance: auto;
		}
	</style>
@endpush

@push('js')
	<script>
		// loadSelectState();
		function loadSelectState() {
			$('.select-state').select2({
				placeholder: "Select State"
			})
		}
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

        $(document).ready(function() {
			loadSelectState();
        });
	</script>
@endpush



