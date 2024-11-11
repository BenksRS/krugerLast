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

    public    $filters  = [
        'commission' => 'percentage'
    ];

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

        $assignmnet = AssignmentFinanceRepository::without([
            'referral', 'carrier', 'status', 'status_collection', 'event', 'phones', 'user_updated', 'user_created',
            'job_types', 'tags', 'workers'
        ])
                                                 ->DateSchedulledWorker($startDate, $endDate, $id, $jobTypes)
                                                 ->whereIn('status_id', [5, 6, 10, 24, 9])
                                                 ->get();

        $comissionsTechs = [];

        foreach ($assignmnet as $job) {

            $rules = $job->commissions->whereIn('user_id', $id);
            if ($filters['commission'] == 'amount') {
                $rules = $rules->whereIn('status', ['pending', 'available']);
            }

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

                $amounts = [
                    'total_job'        => $total_job,
                    'total_tree'       => 0,
                    'total_tarp'       => 0,
                    'total_commission' => 0,
                    'description'      => ''
                ];

                switch ($job_type->id ?? NULL) {
                    case '1':
                    case '2':
                        $comission = $total_tarp * 0.01;
                        $tp        = number_format($total_tarp, 2);
                        $tc        = number_format($comission, 2);
                        //echo "## $job_type->name  #  Total Tarp: $$tp  # comission 1%: $$tc <br>";
                        $text = "## $jobTypeName - # Total Tarp: <b>$$tp</b> - # comission 1%: <b>$$tc</b>";

                        $amounts['total_tarp'] = $tp;
                    break;
                    case '11':
                        $comission = $total_tree * 0.01;
                        $tt        = number_format($total_tree, 2);
                        $tc        = number_format($comission, 2);

                        //echo "## $job_type->name  #  Total Tree: $$tt  # comission 1%: $$tc <br>";
                        $text = "## $jobTypeName - # Total Tree: <b>$$tt</b> - # comission 1%: <b>$$tc</b>";

                        $amounts['total_tree'] = $tt;
                    break;
                    default:
                        $comission = 0;
                        //echo "## $job_type->name  #  No Extra comission <br>";
                        $text = "## $jobTypeName - # No Extra comission";
                    break;
                }

                $amounts['total_commission'] = $comission;
                $amounts['description']      = $text;

                $comissionsTechs[$rule->id] = [
                    'id'            => $rule->id,
                    'user_id'       => $user->id,
                    'user_name'     => $user->name,
                    'assignment_id' => $rule->assignment_id,
                    'status'        => $rule->status,
                    'amount'        => $rule->amount,
                    'amounts'       => $amounts,
                    'job_type'      => $rule->job_type,
                    'text'          => $text,
                    'address'       => $job->address,
                    'rule_name'     => $rule->rule->name,
                    'tree_amount'   => (int) $total_tree ?? 0,
                    'tarp_amount'   => (int) $total_tarp ?? 0,
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

            $total_tree = $item->sum('tree_amount');
            $total_tarp = $item->sum('tarp_amount');
            $total_bill = ($total_tree + $total_tarp);

            $commissions                     = $item->groupBy('status')->map(fn ($item, $key) => $item->sum('amount'));
            $commissions['total']            = number_format($commissions->sum(), 2, '.', ',');
            $commissions['total_commission'] = number_format($item->sum('commission'), 2, '.', ',');
            $commissions['total_tree']       = number_format($total_tree, 2, '.', ',');
            $commissions['total_tarp']       = number_format($total_tarp, 2, '.', ',');
            $commissions['total_bill']       = number_format($total_bill, 2, '.', ',');

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