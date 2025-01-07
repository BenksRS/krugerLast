<?php

namespace Modules\Reports\Http\Livewire\Mkt;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Repositories\CommissionsRepository;
use Modules\User\Entities\User;

class Search extends Component {

    public    $commissionsStatus;

    public    $commissionsTechs;

    public    $jobTypes;

    public    $loading  = FALSE;

    public    $filters  = [
        'commission' => 'percentage'
    ];

    protected $listData = [];

    public function mount()
    {
        $this->commissionsStatus = ['pending' => 'Pending', 'available' => 'Available', 'paid' => 'Paid'];
        $this->commissionsTechs  = User::where('active', 'Y')->where('group_id', '3')->get();
        $this->jobTypes          = AssignmentsJobTypes::where('active', 'Y')->get();
    }

    public function submit()
    {
        $this->listMkt();
    }
    protected function listMkt()
    {
        $filters  = $this->filters;
        $dates    = $filters['dates'] ?? ['start' => '2024-06-01', 'end' => '2024-12-31'];
        $id       = $filters['techs'] ?? ['49'];
        $jobTypes = $filters['job_types'] ?? [];

        $startDate = (new \DateTime($dates['start'] ?? 'first day of this month'))->format('Y-m-d');
        $endDate   = (new \DateTime($dates['end'] ?? 'now'))->format('Y-m-d');

        $total_commission = 0;

        $assignmnet = AssignmentFinanceRepository::without([
            'status', 'status_collection', 'event', 'phones', 'user_updated', 'user_created', 'tags', 'workers'
        ])->with(['commissions.rule'])
            ->DateSchedulledMkt($startDate, $endDate, $id, $jobTypes)
            ->whereIn('status_id', [5, 6, 10, 24, 9])
            ->get();

        $comissionsTechs = [];



        foreach ($assignmnet as $job) {

            $rules = $job->commissions->whereIn('user_id', $id);

            foreach ($rules as $rule) {

                $user     = $this->commissionsTechs->find($rule->user_id);

                $total_job  = $job->finance->invoices->total;
                $comission = $rule->amount;



                $amounts = [
                    'total_job'        => $total_job,
                    'total_commission' => 0,
                    'description'      => ''
                ];


                $text = 'erro';
                $description = $rule->rule->name ;

                $amounts['total_commission'] = $comission;
                $amounts['description']      = $description;

                $addr="$job->city - $job->state";

                $comissionsTechs[$rule->id] = [
                    'id'             => $rule->id,
                    'user_id'        => $user->id,
                    'user_name'      => $user->name,
                    'assignment_id'  => $rule->assignment_id,
                    'status'         => $rule->status,
                    'amount'         => $rule->amount,
                    'amounts'        => $amounts,
                    'job_amount'    => $total_job,
                    'description'    => $description,
                    'address'        => $addr,
                    'referral'        => $job->referral_carrier_full,
                    'rule_name'      => $rule->rule->name,
                    'scheduling_date'     => $job->scheduling->start_date ?? '???',
                    'commission'     => number_format($comission, 2, '.', ',')
                ];

                $total_commission = $total_commission + $comission;

                $total_commissionShow = number_format($total_commission, 2, '.', ',');
                //                echo "<br>tc: $total_commission c:$comission<br>";
            }
            //            dump($job->finance);
        }
        $this->listData = $this->toCollection(collect($comissionsTechs));
    }


    protected function toCollection($data)
    {

        if (empty($data)) {
            return [];
        }


        $collection = $data->groupBy('user_id')->map(function($item, $key) {

            $item    = collect($item);
            $collect = collect();


            $total_bill = $item->sum('job_amount');

            $countType = $item->groupBy('comission_type')->map->count();

            $commissions                     = $item->groupBy('status')->map(fn ($item, $key) => $item->sum('amount'));
            $commissions['total']            = number_format($total_bill, 2, '.', ',');
            $commissions['total_commission'] = number_format($item->sum('amount'), 2, '.', ',');
            $commissions['total_bill']       = number_format($total_bill, 2, '.', ',');
            $commissions['total_count']      = $countType;

            $collect['tech']        = $this->commissionsTechs->firstWhere('id', $key);
            $collect['commissions'] = $commissions;
            $collect['assignments'] = $item;
//dd($collect);
            return $collect;
        });

        return $collection;
    }


    protected function getCommissions()
    {
        $employeeCommissions = CommissionsRepository::whereIn('status', ['pending', 'available'])
            ->whereDate('created_at', '>=', '2024-01-01')
            ->whereNotNull('job_type');
        /*			->whereIn('assignment_id', [
                        44703, 44709, 44710, 44716, 44717, 44778, 44713
                    ])*/

        $employeeCommissions = $employeeCommissions->get();

        $collection = $this->toCollection($employeeCommissions);

        $this->listData = $collection;
    }

    public function render()
    {

        return view('reports::livewire.mkt.search', [
            'listData' => $this->listData,
        ]);
    }

}