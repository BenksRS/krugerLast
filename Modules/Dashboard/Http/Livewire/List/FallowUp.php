<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\AssignmentsStatusCollection;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Referrals\Entities\Referral;

class FallowUp extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Billed Date','Status Collection','Name','Invoices', 'Status','follow_up','days_from_billing','projected_lien','days_from_service', 'Referral','City','State', 'Phone'];
    public $selectedColumns = [];
    public $selectedRows = 100;

    public $selectedStatus;
    public $statusCollection;

    public $total_collection;

    public $allReferrals;

    public $allCarriers;

    public $filters = [
        'referral_id' => NULL,
        'carrier_id'  => NULL,
    ];

    public $formBuilder = [
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

    public function mount ()
    {
        $referrals = Referral::all();

        $this->selectedColumns = $this->columns;

        $this->statusCollection = AssignmentsStatusCollection::all();
        $this->selectedStatus = $this->statusCollection->pluck('id')->toArray();

        $this->allReferrals = $referrals;
        $this->allCarriers  = $referrals;

        /*            $this->fill(['formBuilder.schema' => $this->getFormBuilder()]);*/

        /* $this->formBuilder['schema'] = $this->getFormBuilder();*/

    }
    public function updatingSearchAssignment ()
    {
        $this->resetPage();
    }

    public function updatingFilters ()
    {
        $this->resetPage();
    }

    public function filter ( $field, $value )
    {
        $this->filters[$field] = $value;
        $this->resetPage();
    }

    public function clearFilter ( $field )
    {
        $this->filters[$field] = NULL;
        $this->resetPage();
    }
    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $today=Carbon::now();
//        dd($this->selectedStatus);
        $list = AssignmentFinanceRepository::collection($this->selectedStatus)->whereDate('follow_up', '<=',$today)->search($searchAssignment)->when($this->filters, function ( $query, $search ) {
            $search = array_filter($search);
            foreach ( $search as $key => $value ) {
                $query->where($key, $value);
            }
        })->get();

        $total_collection=$list->sum('finance.invoices.total');
        $this->total_collection = number_format($total_collection, 2);

        $list=$list->sortByDesc($this->sortBy);

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.fallow-up',[
            'list' =>$list
        ]);
    }

}