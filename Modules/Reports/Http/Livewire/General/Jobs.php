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

    public $sortField = 'schedule';
    public $sortDir   = 'asc';

    public $bdSortField = 'billed';
    public $bdSortDir   = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDir   = 'asc';
        }

        $this->resetPage();
    }

    public function sortBreakdownBy($field)
    {
        if ($this->bdSortField === $field) {
            $this->bdSortDir = $this->bdSortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->bdSortField = $field;
            $this->bdSortDir   = 'desc';
        }
    }

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

    protected function jobDiscount($row)
    {
        return (float) optional(optional($row->finance)->invoices)->discount;
    }

    /** job_type_id de "ROOF TARP" */
    const JOB_TYPE_ROOF_TARP = 1;

    /** job_type_id de "TREE REMOVAL" */
    const JOB_TYPE_TREE_REMOVAL = 11;

    public function getWorkerBreakdown($list)
    {
        $breakdown = [];

        foreach ($list as $row) {
            $ids = $row->workers->pluck('worker_id')->unique();
            if (!empty($this->workersSelected)) {
                $ids = $ids->intersect($this->workersSelected);
            }

            // workers que estao no job report de cada job type de comissao
            $tarpWorkers = $row->workers
                ->where('job_type_id', self::JOB_TYPE_ROOF_TARP)
                ->pluck('worker_id')->unique();
            $treeWorkers = $row->workers
                ->where('job_type_id', self::JOB_TYPE_TREE_REMOVAL)
                ->pluck('worker_id')->unique();

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
                        'paid'     => 0,
                        'balance'  => 0,
                        'crane'    => 0,
                        'discount' => 0,
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

                // Tree removal so conta se o worker esta no job report de TREE REMOVAL
                if ($treeWorkers->contains($workerId)) {
                    $breakdown[$workerId]['tree_net'] += $treeNet;
                }

                // Tarp so conta se o worker esta no job report de ROOF TARP
                if ($tarpWorkers->contains($workerId)) {
                    $breakdown[$workerId]['tarp'] += ($billed - $tree);
                }

                $breakdown[$workerId]['paid']    += $this->jobPaid($row);
                $breakdown[$workerId]['balance'] += $this->jobBalance($row);
                $breakdown[$workerId]['crane']    += $this->jobCrane($row);
                $breakdown[$workerId]['discount'] += $this->jobDiscount($row);
            }
        }

        $breakdown = collect($breakdown);
        $field     = $this->bdSortField ?: 'billed';

        return $this->bdSortDir === 'asc'
            ? $breakdown->sortBy($field)->values()
            : $breakdown->sortByDesc($field)->values();
    }

    public function render()
    {
        $list = collect($this->list)->values();

        $sorters = [
            'name'        => fn ($r) => strtolower($r->last_name . ' ' . $r->first_name),
            'job_type'    => fn ($r) => strtolower((string) optional($r->job_types->first())->name),
            'schedule'    => fn ($r) => optional($r->scheduling)->start_date ?? $r->created_at,
            'status'      => fn ($r) => strtolower((string) optional($r->status)->name),
            'referral'    => fn ($r) => strtolower((string) $r->referral_carrier_full),
            'workers'     => fn ($r) => strtolower((string) $r->workers
                ->pluck('worker_id')->unique()
                ->map(fn ($id) => $this->workerMap[$id] ?? ('#' . $id))
                ->sort()->implode(', ')),
            'billed'      => fn ($r) => $this->jobBilled($r),
            'tree'        => fn ($r) => $this->jobTree($r),
            'third_party' => fn ($r) => $this->jobThirdParty($r),
            'tree_net'    => fn ($r) => $this->jobTree($r) - $this->jobThirdParty($r),
            'tarp'        => fn ($r) => $this->jobBilled($r) - $this->jobTree($r),
            'paid'        => fn ($r) => $this->jobPaid($r),
            'balance'     => fn ($r) => $this->jobBalance($r),
            'crane'       => fn ($r) => $this->jobCrane($r),
            'discount'    => fn ($r) => $this->jobDiscount($r),
            'billed_date' => fn ($r) => optional(optional($r->finance)->collection)->billed_date,
            'paid_date'   => fn ($r) => optional(optional($r->finance)->collection)->paid_date,
        ];

        $sorter = $sorters[$this->sortField] ?? $sorters['schedule'];
        $list   = ($this->sortDir === 'desc'
            ? $list->sortByDesc($sorter)
            : $list->sortBy($sorter))->values();

        $totals = [
            'jobs'        => $list->count(),
            'billed'      => $list->sum(fn ($row) => $this->jobBilled($row)),
            'tree'        => $list->sum(fn ($row) => $this->jobTree($row)),
            'third_party' => $list->sum(fn ($row) => $this->jobThirdParty($row)),
            'paid'        => $list->sum(fn ($row) => $this->jobPaid($row)),
            'balance'     => $list->sum(fn ($row) => $this->jobBalance($row)),
            'crane'       => $list->sum(fn ($row) => $this->jobCrane($row)),
            'discount'    => $list->sum(fn ($row) => $this->jobDiscount($row)),
        ];
        $totals['tree_net'] = $totals['tree'] - $totals['third_party'];
        $totals['tarp']     = $totals['billed'] - $totals['tree'];

        $items     = $list->forPage($this->page, $this->selectedRows);
        $paginated = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('reports::livewire.general.jobs', [
            'listAll'   => $paginated,
            'totals'    => $totals,
            'breakdown' => $this->getWorkerBreakdown($list),
        ]);
    }
}
