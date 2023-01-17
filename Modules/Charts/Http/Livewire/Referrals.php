<?php

namespace Modules\Charts\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Referrals\Entities\Referral;

class Referrals extends Component {

    public array $chartData = [
        'labels'   => [],
        'datasets' => [],
    ];

    public $listData = [];

    protected $listeners = [
        'filter'  => 'filter',
    ];

    public function mount ()
    {

        $this->listData = collect($this->listData);


        $this->setChartData();

    }

    public function filter ( $filters )
    {
        $this->setChartData($filters);
    }

    private function setChartData ( $filters = NULL )
    {
        if ( !$filters )
            return;

        $data = Referral::withCount('assignments')->whereHas('assignments', function ( $query ) use ( $filters ) {
            if ( $filters ) {
                $query->whereDate('created_at', '>=', $filters['start']);
                $query->whereDate('created_at', '<=', $filters['end']);
            }
        })->get();

        $sum = $data->sum('assignments_count');

        $graph = $data->map(fn ( $item ) => [
            'name'    => Str::title($item->company_entity),
            'total'   => $item->assignments_count,
            'percent' => round($item->assignments_count / $sum * 100, 2),
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

    public function render ()
    {
        return view('charts::livewire.referrals');
    }

}
