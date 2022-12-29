<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\AssignmentFinance;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Referrals\Entities\Referral;

class Collection extends Component {

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public    $searchAssignment;

    public    $columns         = ['Billed Date', 'Status Collection', 'Name', 'Invoices', 'Status', 'days_from_billing', 'days_from_service', 'Referral', 'City', 'State', 'Phone'];

    public    $selectedColumns = [];

    public    $selectedRows    = 100;

    public    $total_collection;

    public    $allReferrals;

    public    $allCarriers;

    public    $filters         = [
        'referral_id' => NULL,
        'carrier_id'  => NULL,
    ];

    public    $inputFilters    = [
        'fields' => [],
        'search' => [],
    ];

    public function mount ()
    {
        $referralBase = Referral::all();

        $this->selectedColumns = $this->columns;

        $this->allReferrals = $referralBase;
        $this->allCarriers = $referralBase;

    }

    public function inputFilters ()
    {
        $collection = [
            'referrals' => [
                'type'    => 'select',
                'name'    => 'referral_id',
                'label'   => 'Referral',
                'options' => $this->allReferrals,
            ],
            'carriers'  => [
                'type'    => 'select',
                'name'    => 'carrier_id',
                'label'   => 'Carrier',
                'options' => $this->allCarriers,
            ],
        ];

    }

    public function updatingSearchAssignment ()
    {
        $this->resetPage();
    }

    public function clearFilter ( $field )
    {

        $this->filters[$field] = NULL;
    }

    public function render ()
    {
        $searchAssignment = $this->searchAssignment;
        $list = AssignmentFinanceRepository::collection()
                                           ->search($searchAssignment)
                                           ->when($this->filters, function ( $query, $search ) {
                                               $search = array_filter($search);
                                               foreach ( $search as $key => $value ) {
                                                   $query->where($key, $value);
                                               }
                                           })
                                           ->get();

        $total_collection = $list->sum('finance.invoices.total');
        $this->total_collection = number_format($total_collection, 2);

        $list = $list->sortByDesc('finance.collection.days_from_billing');

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.collection', [
            'list' => $list
        ]);
    }

}
