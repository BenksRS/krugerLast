<?php

namespace Modules\Reports\Http\Livewire\General;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\User\Entities\Workers;

class Jobs extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $list;
    public $workersSelected = [];
    public $selectedRows = 100;
    public $workerMap = [];

    public function mount($test, $workersSelected = [])
    {
        $this->list            = $test;
        $this->workersSelected = array_filter((array) $workersSelected);

        $this->workerMap = Workers::with('user')->get()
            ->pluck('user.name', 'user.id')
            ->toArray();
    }

    protected function money($value)
    {
        return number_format((float) $value, 2, '.', ',');
    }

    protected function jobBilled($row)
    {
        return (float) optional(optional($row->finance)->invoices)->total;
    }

    protected function jobTree($row)
    {
        $invoices = optional(optional($row->finance)->invoices);

        return (float) ($invoices->tree_amount_total ?? $invoices->tree_amount);
    }

    protected function jobThirdParty($row)
    {
        return (float) optional(optional($row->finance)->invoices)->third_party;
    }

    protected function jobPaid($row)
    {
        return (float) optional(optional($row->finance)->payments)->total;
    }

    protected function jobBalance($row)
    {
        return (float) optional(optional($row->finance)->balance)->total;
    }

    protected function jobCrane($row)
    {
        return (float) optional(optional($row->finance)->invoices)->crane_amount;
    }

    public function getWorkerBreakdown($list)
    {
        $breakdown = [];

        foreach ($list as $row) {
            $ids = $row->workers->pluck('worker_id')->unique();
            if (!empty($this->workersSelected)) {
                $ids = $ids->intersect($this->workersSelected);
            }

            foreach ($ids as $workerId) {
                if (!isset($breakdown[$workerId])) {
                    $breakdown[$workerId] = [
                        'name'    => $this->workerMap[$workerId] ?? ('#' . $workerId),
                        'jobs'        => 0,
                        'billed'      => 0,
                        'tree'        => 0,
                        'third_party' => 0,
                        'tree_net'    => 0,
                        'tarp'        => 0,
                        'paid'    => 0,
                        'balance' => 0,
                        'crane'   => 0,
                    ];
                }

                $billed     = $this->jobBilled($row);
                $tree       = $this->jobTree($row);
                $thirdParty = $this->jobThirdParty($row);
                $treeNet    = $tree - $thirdParty;

                $breakdown[$workerId]['jobs']++;
                $breakdown[$workerId]['billed']      += $billed;
                $breakdown[$workerId]['tree']        += $tree;
                $breakdown[$workerId]['third_party'] += $thirdParty;
                $breakdown[$workerId]['tree_net']    += $treeNet;
                $breakdown[$workerId]['tarp']        += ($billed - $treeNet);
                $breakdown[$workerId]['paid']    += $this->jobPaid($row);
                $breakdown[$workerId]['balance'] += $this->jobBalance($row);
                $breakdown[$workerId]['crane']   += $this->jobCrane($row);
            }
        }

        return collect($breakdown)->sortByDesc('billed');
    }

    public function render()
    {
        $list = collect($this->list)
            ->sortBy(fn ($row) => optional($row->scheduling)->start_date ?? $row->created_at)
            ->values();

        $totals = [
            'jobs'        => $list->count(),
            'billed'      => $list->sum(fn ($row) => $this->jobBilled($row)),
            'tree'        => $list->sum(fn ($row) => $this->jobTree($row)),
            'third_party' => $list->sum(fn ($row) => $this->jobThirdParty($row)),
            'paid'        => $list->sum(fn ($row) => $this->jobPaid($row)),
            'balance'     => $list->sum(fn ($row) => $this->jobBalance($row)),
            'crane'       => $list->sum(fn ($row) => $this->jobCrane($row)),
        ];
        $totals['tree_net'] = $totals['tree'] - $totals['third_party'];
        $totals['tarp']     = $totals['billed'] - $totals['tree_net'];

        $items     = $list->forPage($this->page, $this->selectedRows);
        $paginated = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('reports::livewire.general.jobs', [
            'listAll'   => $paginated,
            'totals'    => $totals,
            'breakdown' => $this->getWorkerBreakdown($list),
        ]);
    }
}
