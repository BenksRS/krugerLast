<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Dashboard\Traits\FollowupReportFullFields;

class Fallowup60 extends Component
{
    use FollowupReportFullFields;

    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $today = Carbon::now();
        $list = AssignmentFinanceRepository::Collection($this->selectedStatus)
            ->whereDate('follow_up', '<=', $today)
            ->BilledDaysAgoAtMost(60)
            ->search($searchAssignment)->when($this->filters, function ( $query, $search ) {
                $search = array_filter($search);
                foreach ( $search as $key => $value ) {
                    $query->where($key, $value);
                }
            })->get();

        $list = $list->where('finance.collection.days_from_billing', '<', 60);
        $total_collection = $list->sum('finance.invoices.total');
        $this->total_collection = number_format($total_collection, 2);

        $list = $list->sortBy($this->sortBy);

        $items = $list->forPage($this->page, $this->selectedRows);

        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.fallowup60', [
            'list' => $list
        ]);
    }
}
