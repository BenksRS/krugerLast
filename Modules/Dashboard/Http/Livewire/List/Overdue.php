<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\AssignmentsStatusCollection;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Referrals\Entities\Referral;

class Overdue extends Component {

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public    $searchAssignment;

    public    $columns         = ['Billed Date', 'Status Collection', 'Name', 'Invoices', 'Status', 'follow_up', 'days_from_billing', 'days_from_service', 'Referral', 'City', 'State', 'Phone'];

    public    $selectedColumns = [];

    public    $selectedRows    = 100;

    public    $total_collection;

    public    $allReferrals;

    public    $selectedStatus;

    public    $statusCollection;

    public    $allCarriers;

    public    $filters         = [
        'referral_id' => NULL,
        'carrier_id'  => NULL,
    ];

    public    $formBuilder     = [
        'schema' => [],
        'search' => [],
    ];

    public $sortByColumns   = [
        'follow_up'         => 'Follow UP',
        'days_from_billing' => 'Days From Billing',
        'days_from_service' => 'Days From Service',
        'state'             => 'State',
    ];

    public $sortBy = 'follow_up';

    public function mount()
    {
        $referrals = Referral::all();
        $statusCollection = AssignmentsStatusCollection::all();

        $this->selectedColumns = $this->columns;

        $this->statusCollection = $statusCollection->pluck('name','id')->all();
        $this->selectedStatus   = $statusCollection->pluck('id')->all();

        /*  dd($this->selectedStatus, $this->statusCollection);*/

        $this->allReferrals = $referrals->pluck('full_name', 'id')->all();
        $this->allCarriers  = $this->allReferrals;

        /*            $this->fill(['formBuilder.schema' => $this->getFormBuilder()]);*/
        /* $this->formBuilder['schema'] = $this->getFormBuilder();*/
    }

    protected function getFormBuilder()
    {
        $referrals = Referral::cursor();

        return [
            'referrals' => [
                'text' => 'Referral',
                'name' => 'referral_id',
                'type' => 'select',
                'data' => $referrals,
            ],
            'carriers'  => [
                'text' => 'Carrier',
                'name' => 'carrier_id',
                'type' => 'select',
                'data' => $referrals,
            ],
        ];
    }

    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function filter($field, $value)
    {
        $this->filters[$field] = $value;
        $this->resetPage();
    }

    public function clearFilter($field)
    {
        $this->filters[$field] = NULL;
        $this->resetPage();
    }

    public function render()
    {
        //        dd($this->selectedStatus);
        $searchAssignment = $this->searchAssignment;
        $today            = Carbon::now();
        $list             = AssignmentFinanceRepository::collection($this->selectedStatus)->search($searchAssignment)->when($this->filters, function($query, $search) {
            $search = array_filter($search);
            foreach ($search as $key => $value) {
                $value = is_array($value) ? $value : [$value];
                $query->whereIn($key, $value);
            }
        })->get();

        $list                   = $list->where('finance.collection.days_from_billing', '>', 30);
        $total_collection       = $list->sum('finance.balance.total');
        $this->total_collection = number_format($total_collection, 2);

        $list = $list->sortBy($this->sortBy);

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.overdue', [
            'list' => $list
        ]);
    }

}