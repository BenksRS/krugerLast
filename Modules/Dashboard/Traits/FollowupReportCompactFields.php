<?php

namespace Modules\Dashboard\Traits;

use Modules\Assignments\Entities\AssignmentsStatusCollection;
use Modules\Referrals\Entities\Referral;

/**
 * Shared boilerplate for the "compact" follow-up report family (Fallowup30, Fallowup45):
 * status/referral options are plucked into simple id=>name arrays for the filter dropdowns,
 * and the `filters` closure in render() matches with whereIn(). This mirrors what was
 * previously duplicated verbatim across those two components.
 */
trait FollowupReportCompactFields {

    use \Livewire\WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $searchAssignment;
    public $columns = ['Billed Date', 'Status Collection', 'Name', 'Invoices', 'Status', 'projected_lien', 'follow_up', 'days_from_billing', 'days_from_service', 'Referral', 'City', 'State', 'Phone'];
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

    public $sortByColumns = [
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

        $this->statusCollection = $statusCollection->pluck('name', 'id')->all();
        $this->selectedStatus   = $statusCollection->pluck('id')->all();

        $this->allReferrals = $referrals->pluck('full_name', 'id')->all();
        $this->allCarriers  = $this->allReferrals;
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
}
