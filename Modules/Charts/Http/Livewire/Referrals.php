<?php

namespace Modules\Charts\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Charts\Repositories\ReferralRepository;

class Referrals extends Component {

    public array $chartData = [
        'labels'   => [],
        'datasets' => [],
    ];

    public $listData = [];

    protected $listeners = [
        'filter' => 'filter',
    ];

    public function mount ()
    {
        $this->listData = collect($this->listData);
    }

    public function filter ( $filters )
    {
        $this->setChartData($filters);
    }

    private function setChartData ( $filters = NULL )
    {
        if ( !$filters )
            return;

        $data = ReferralRepository::whereHas('assignments', function ( $query ) use ( $filters ) {
            $query->dateRange($filters['start'], $filters['end']);
        })->withCount([
            'assignments' => function ( $query ) use ( $filters ) {
                $query->dateRange($filters['start'], $filters['end']);
            }
        ])->get();

        $sum = $data->sum('assignments_count');

        $graph = $data->map(fn ( $item ) => [
            'name'    => Str::title($item->company_entity),
            'total'   => $item->assignments_count,
            'percent' => round(($item->assignments_count * 100) / $sum, 2)
        ])->sortByDesc('total');

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
        return view('charts::livewire.referrals');
    }

}
