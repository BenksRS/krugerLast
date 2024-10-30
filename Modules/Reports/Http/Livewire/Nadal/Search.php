<?php

namespace Modules\Reports\Http\Livewire\Nadal;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Repositories\CommissionsRepository;
use Modules\User\Entities\User;

class Search extends Component {

    public    $commissionsStatus;

    public    $commissionsTechs;

    public    $jobTypes;

    public    $loading  = FALSE;

    public    $filters;

    protected $listData = [];

    public function mount()
    {
        $this->commissionsStatus = ['pending' => 'Pending', 'available' => 'Available', 'paid' => 'Paid'];
        $this->commissionsTechs  = User::where('active', 'Y')->get();
        $this->jobTypes          = AssignmentsJobTypes::where('active', 'Y')->get();
    }

    public function submit()
    {
        $this->listWorkers();
    }

    protected function listWorkers()
    {
        $filters  = $this->filters;
        $dates    = $filters['dates'] ?? ['start' => '2022-06-01', 'end' => '2022-12-31'];
        $id       = $filters['techs'] ?? [];
        $jobTypes = $filters['job_types'] ?? [];

        $startDate = (new \DateTime($dates['start'] ?? 'first day of this month'))->format('Y-m-d');
        $endDate   = (new \DateTime($dates['end'] ?? 'now'))->format('Y-m-d');

        $total_commission = 0;

        $assignmnet = AssignmentFinanceRepository::without(['referral','carrier','status','status_collection','event','phones','user_updated','user_created','job_types','tags', 'workers'])
                                                 ->DateSchedulledWorker($startDate, $endDate, $id, $jobTypes)
                                                 ->whereIn('status_id', [5, 6, 10, 24, 9])
                                                 ->get();

        $comissionsTechs = [];

        foreach ($assignmnet as $job) {

            $rules = $job->commissions->whereIn('user_id', $id);

            /*            echo "<br>## $job->id<br>";*/
            /*     if (!$rules->count()) {
                     continue;
                 }*/

            foreach ($rules as $rule) {
                $job_type = $this->jobTypes->find($rule->job_type);
                $user     = $this->commissionsTechs->find($rule->user_id);

                $total_job  = $job->finance->invoices->total;
                $total_tree = $job->finance->invoices->tree_amount;
                $total_tarp = $total_job - $total_tree;

                $jobTypeName = $job_type->name ?? '';

                switch ($job_type->id ?? NULL) {
                    case '1':
                    case '2':
                        $comission = $total_tarp * 0.01;
                        $tp        = number_format($total_tarp, 2);
                        $tc        = number_format($comission, 2);
                        //echo "## $job_type->name  #  Total Tarp: $$tp  # comission 1%: $$tc <br>";
                        $text = "## $jobTypeName - # Total Tarp: <b>$$tp</b> - # comission 1%: <b>$$tc</b>";
                    break;
                    case '11':
                        $comission = $total_tree * 0.01;
                        $tt        = number_format($total_tree, 2);
                        $tc        = number_format($comission, 2);
                        //echo "## $job_type->name  #  Total Tree: $$tt  # comission 1%: $$tc <br>";
                        $text = "## $jobTypeName - # Total Tree: <b>$$tt</b> - # comission 1%: <b>$$tc</b>";
                    break;
                    default:
                        $comission = 0;
                        //echo "## $job_type->name  #  No Extra comission <br>";
                        $text = "## $jobTypeName " ?? ''." - # No Extra comission";
                    break;
                }

                $comissionsTechs[$rule->id] = [
                    'id'            => $rule->id,
                    'user_id'       => $user->id,
                    'user_name'     => $user->name,
                    'assignment_id' => $rule->assignment_id,
                    'status'        => $rule->status,
                    'amount'        => $rule->amount,
                    'job_type'      => $rule->job_type,
                    'text'          => $text,
                    'commission'    => number_format($comission, 2, '.', ',')
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

            $commissions                     = $item->groupBy('status')->map(fn ($item, $key) => $item->sum('amount'));
            $commissions['total']            = $commissions->sum();
            $commissions['total_commission'] = number_format($item->sum('commission'), 2, '.', ',');

            $collect['tech']        = $this->commissionsTechs->firstWhere('id', $key);
            $collect['commissions'] = $commissions;
            $collect['assignments'] = $item;

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

        return view('reports::livewire.nadal.search', [
            'listData' => $this->listData,
        ]);
    }

}