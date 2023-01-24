<?php

namespace Modules\Charts\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Charts\Repositories\AssignmentRepository;
use Modules\Charts\Repositories\Referral\ReferralRepository;

class Show extends Component {

	protected $listeners = [
		'chart::filter' => 'filter',
	];

	public $listData = [];

	public array $chartData = [
		'labels'   => [],
		'datasets' => [],
	];

	public array $loadData = [
		'loading' => FALSE,
		'view'    => NULL,
		'views'   => [
			'referral'          => 'charts::show.referral.referrals',
			'referral_carriers' => 'charts::show.referral.referrals',
			'referral_types'    => 'charts::show.referral.types',
		]
	];

	public function mount ()
	{
		$this->listData = collect();
	}

	public function filter ( $filters )
	{

		$this->filterByType($filters);

	}

	protected function filterByType ( $filters )
	{
		$type  = $filters['referral'];
		$dates = $filters['dates'];

		$this->loadData['loading'] = TRUE;
		$this->loadData['view']    = $this->loadData['views'][$type];

		$repo = AssignmentRepository::withOnly(['referral.type', 'carrier'])->dateRange($dates['start'], $dates['end']);

		switch( $type ) {
			case 'referral':
				$repo  = $repo->selectRaw('referral_id, count(*) as total')->groupBy('referral_id')->get();
				$count = $repo->sum('total');

				$repo = $repo->map(function( $item ) use ( $count ) {
					$item->name       = Str::title($item->referral->company_entity);
					$item->percentage = round(($item->total / $count) * 100, 2);

					return $item;
				});
			break;
			case 'referral_carriers':
				$repo  = $repo->selectRaw('referral_id, carrier_id, count(*) as total')->has('carrier')->groupBy('referral_id', 'carrier_id')->get();
				$count = $repo->sum('total');

				$repo = $repo->map(function( $item ) use ( $count ) {
					$item->name       = Str::title($item->referral_carrier);
					$item->percentage = round(($item->total / $count) * 100, 2);

					return $item;
				});
			break;
			case 'referral_types':
				$repo  = $repo->get();
				$count = $repo->count();

				$repo = collect($repo)->groupBy('referral.type.id')->map(function( $item, $typeId ) use ( $count ) {

					$referralType = $item->firstWhere('referral.type.id', $typeId)->referral->type;

					$type       = new \stdClass();
					$type->name = $referralType->name;

					$type->total      = $item->count();
					$type->percentage = round(($type->total / $count) * 100, 2);

					$total = $type->total;

					$type->data = $item->groupBy('referral.id')->map(function( $data, $referralId ) use ( $total ) {

						$referral = $data->firstWhere('referral.id', $referralId);

						$items             = new \stdClass();
						$items->name       = Str::title($referral->referral->company_entity);
						$items->total      = $data->count();
						$items->percentage = round(($data->count() / $total) * 100, 2);

						return collect($items);

					});

					return collect($type);
				});
			break;
			default:
			break;
		}

		$data = $repo->sortByDesc('total');

		$this->chartData = [
			'labels'   => $data->pluck('name')->toArray(),
			'datasets' => [
				[
					'data' => $data->pluck('percentage')->toArray(),
				],
			],
		];

		$this->listData = $data;

		$this->emit('updateChart', $this->chartData);

	}

	private function setChartData ( $filters = NULL )
	{
		if( !$filters )
			return;

		$data = ReferralRepository::whereHas('assignments', function( $query ) use ( $filters ) {
			$query->dateRange($filters['start'], $filters['end']);
		})->withCount([
			'assignments' => function( $query ) use ( $filters ) {
				$query->dateRange($filters['start'], $filters['end']);
			}
		])->get();

		$sum = $data->sum('assignments_count');

		$graph = $data->map(fn( $item ) => [
			'name'    => Str::title($item->full_name),
			'total'   => $item->assignments_count,
			'percent' => round(($item->assignments_count * 100) / $sum, 2)
		])->sortBy('name')->sortByDesc('total');

		$this->chartData['labels']   = $graph->pluck('name')->toArray();
		$this->chartData['datasets'] = [
			[
				'data' => $graph->pluck('percent')->toArray(),
			],
		];

		$this->listData = $graph;

		$this->emit('updateChart', $this->chartData);

	}

	public function toMap ( $item )
	{
		return [
			'name'    => $item->name,
			'total'   => $item->total,
			'percent' => $item->percent,
		];
	}

	public function render ()
	{

		return view('charts::livewire.show');
	}

}
