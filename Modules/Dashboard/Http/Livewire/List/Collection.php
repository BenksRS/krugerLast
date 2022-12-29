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

        public $searchAssignment;

        public $columns = [
            'Billed Date',
            'Status Collection',
            'Name',
            'Invoices',
            'Status',
            'days_from_billing',
            'days_from_service',
            'Referral',
            'City',
            'State',
            'Phone'
        ];

        public $selectedColumns = [];

        public $selectedRows = 100;

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

        public function mount ()
        {
            $this->selectedColumns = $this->columns;

            $this->allReferrals = Referral::all();
            $this->allCarriers  = Referral::all();

            /*$this->formBuilder['schema'] = $this->getFormBuilder();*/

        }

        protected function getFormBuilder ()
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

        public function render ()
        {
            $searchAssignment = $this->searchAssignment;
            $list             = AssignmentFinanceRepository::collection()->search($searchAssignment)->when($this->filters, function ( $query, $search ) {
                $search = array_filter($search);
                foreach ( $search as $key => $value ) {
                    $query->where($key, $value);
                }
            })->get();

            $total_collection       = $list->sum('finance.invoices.total');
            $this->total_collection = number_format($total_collection, 2);

            $list = $list->sortByDesc('finance.collection.days_from_billing');

            $items = $list->forPage($this->page, $this->selectedRows);

            $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

            return view('dashboard::livewire.list.collection', [
                'list' => $list
            ]);
        }

    }
