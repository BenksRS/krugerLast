<?php

namespace Modules\Referrals\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Referrals\Repositories\ReferralsRepository;
use Modules\User\Entities\Marketing;

class ListInactives extends Component {

    use WithPagination;

    protected $paginationTheme  = 'bootstrap';

    public    $searchAssignment;

    public    $columns          = ['Id', 'Name', 'Type', 'Marketing', 'status', 'Address'];

    public    $selectedColumns  = [];

    public    $selectedJobsSent = ['Y', 'N'];

    public    $marketing;

    public    $selectedMarketing;

    public    $selectedStatus   = ['ACTIVE', 'BLOCKED'];

    public    $selectedRows     = 100;

    public function mount()
    {
        $this->selectedColumns   = $this->columns;
        $this->marketing         = Marketing::all();
        $this->selectedMarketing = $this->marketing->pluck('id')->toArray();
    }

    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }

    protected function toCollection($data)
    {
        $data       = $data->where('jobs_sent', 'Y')->where('days_last_job', '>=', 60);
        $collection = collect($data);

        $collection = $collection->map(function($item, $key) {
            $item               = collect($item);
            $collect            = collect();
            $item['collection'] = [

                'name'          => "{$item['company_entity']} ({$item['company_fictitions']})",
                'type'          => $item['type']['name'],
                'email'         => $item['email'],
                'email'         => $item['email'],
                'address'       => "{$item['street']}, {$item['city']}, {$item['state']} - {$item['zipcode']}",
                'last_job_sent' => $item['lastjob']['created_date'],
                'days_last_job' => $item['days_last_job'],
                'phones'        => collect($item['phones'])->map(function($phone, $key) {
                    return "({$phone['contact']}) - {$phone['phone']}";
                })->toArray(),

            ];

            return $item['collection'];
        });

        dd($collection->toJson());
    }

    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list             = ReferralsRepository::without(['authorizathions'])->with(['marketing', 'phones'])->Searchtopref($searchAssignment, $this->selectedMarketing)
            ->whereIn('status', $this->selectedStatus)
            ->whereIn('referral_type_id', [1, 2, 3])
            ->get();

        $list = $list->sortByDesc('jobs_sent')->sortByDesc('days_last_job');
        /*$this->toCollection($list);*/
        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);



        return view('referrals::livewire.list-inactives', [
            'list' => $list
        ]);
    }

}