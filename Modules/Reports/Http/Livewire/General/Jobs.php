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

    /** job_type_id de "ROOF TARP" */
    const JOB_TYPE_ROOF_TARP = 1;

    /** job_type_id de "TREE REMOVAL" */
    const JOB_TYPE_TREE_REMOVAL = 11;

    protected function jobBilled($row)
    {
        return (float) optional(optional($row->finance)->invoices)->total;
    }

    /** Valor bruto de tree do job (independente de quem fez). */
    protected function jobTreeGross($row)
    {
        $invoices = optional(optional($row->finance)->invoices);

        return (float) ($invoices->tree_amount_total ?? $invoices->tree_amount);
    }

    protected function rawThirdParty($row)
    {
        return (float) optional(optional($row->finance)->invoices)->third_party;
    }

    /**
     * Sem worker filtrado -> conta para todos.
     * Com worker(s) filtrado(s) -> so conta se algum deles estiver no
     * job report do job type informado.
     */
    protected function selectedInReport($row, $jobTypeId)
    {
        if (empty($this->workersSelected)) {
            return true;
        }

        return $row->workers
            ->where('job_type_id', $jobTypeId)
            ->pluck('worker_id')
            ->intersect($this->workersSelected)
            ->isNotEmpty();
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

    /**
     * Monta os valores exibidos de cada linha ja aplicando a regra:
     * Tree/3d Party so contam se o worker filtrado esta no report de
     * Tree Removal; Tarp so conta se esta no report de Roof Tarp.
     */
    protected function buildRow($row)
    {
        $billed     = $this->jobBilled($row);
        $treeGross  = $this->jobTreeGross($row);

        $inTree = $this->selectedInReport($row, self::JOB_TYPE_TREE_REMOVAL);
        $inTarp = $this->selectedInReport($row, self::JOB_TYPE_ROOF_TARP);

        $tree       = $inTree ? $treeGross : 0.0;
        $thirdParty = $inTree ? $this->rawThirdParty($row) : 0.0;
        $tarp       = $inTarp ? ($billed - $treeGross) : 0.0;

        return (object) [
            'model'       => $row,
            'billed'      => $billed,
            'tree'        => $tree,
            'third_party' => $thirdParty,
            'tree_net'    => $tree - $thirdParty,
            'tarp'        => $tarp,
            'paid'        => $this->jobPaid($row),
            'balance'     => $this->jobBalance($row),
            'crane'       => $this->jobCrane($row),
            'discount'    => $this->jobDiscount($row),
        ];
    }

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
                $tree       = $this->jobTreeGross($row);
                $thirdParty = $this->rawThirdParty($row);
                $treeNet    = $tree - $thirdParty;

                $breakdown[$workerId]['jobs']++;
                $breakdown[$workerId]['billed'] += $billed;

                // Tree / 3d Party / Tree - 3d Party so contam se o worker
                // esta no job report de TREE REMOVAL daquele job
                if ($treeWorkers->contains($workerId)) {
                    $breakdown[$workerId]['tree']        += $tree;
                    $breakdown[$workerId]['third_party'] += $thirdParty;
                    $breakdown[$workerId]['tree_net']    += $treeNet;
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
        $rows = collect($this->list)->map(fn ($row) => $this->buildRow($row))->values();

        $sorters = [
            'name'        => fn ($r) => strtolower($r->model->last_name . ' ' . $r->model->first_name),
            'job_type'    => fn ($r) => strtolower((string) optional($r->model->job_types->first())->name),
            'schedule'    => fn ($r) => optional($r->model->scheduling)->start_date ?? $r->model->created_at,
            'status'      => fn ($r) => strtolower((string) optional($r->model->status)->name),
            'referral'    => fn ($r) => strtolower((string) $r->model->referral_carrier_full),
            'workers'     => fn ($r) => strtolower((string) $r->model->workers
                ->pluck('worker_id')->unique()
                ->map(fn ($id) => $this->workerMap[$id] ?? ('#' . $id))
                ->sort()->implode(', ')),
            'billed'      => fn ($r) => $r->billed,
            'tree'        => fn ($r) => $r->tree,
            'third_party' => fn ($r) => $r->third_party,
            'tree_net'    => fn ($r) => $r->tree_net,
            'tarp'        => fn ($r) => $r->tarp,
            'paid'        => fn ($r) => $r->paid,
            'balance'     => fn ($r) => $r->balance,
            'crane'       => fn ($r) => $r->crane,
            'discount'    => fn ($r) => $r->discount,
            'billed_date' => fn ($r) => optional(optional($r->model->finance)->collection)->billed_date,
            'paid_date'   => fn ($r) => optional(optional($r->model->finance)->collection)->paid_date,
        ];

        $sorter = $sorters[$this->sortField] ?? $sorters['schedule'];
        $rows   = ($this->sortDir === 'desc'
            ? $rows->sortByDesc($sorter)
            : $rows->sortBy($sorter))->values();

        $totals = [
            'jobs'        => $rows->count(),
            'billed'      => $rows->sum('billed'),
            'tree'        => $rows->sum('tree'),
            'third_party' => $rows->sum('third_party'),
            'paid'        => $rows->sum('paid'),
            'balance'     => $rows->sum('balance'),
            'crane'       => $rows->sum('crane'),
            'discount'    => $rows->sum('discount'),
        ];
        $totals['tree_net'] = $totals['tree'] - $totals['third_party'];
        $totals['tarp']     = $rows->sum('tarp');

        $items     = $rows->forPage($this->page, $this->selectedRows);
        $paginated = new LengthAwarePaginator($items, $rows->count(), $this->selectedRows, $this->page);

        return view('reports::livewire.general.jobs', [
            'listAll'   => $paginated,
            'totals'    => $totals,
            'breakdown' => $this->getWorkerBreakdown(collect($this->list)),
        ]);
    }
}
