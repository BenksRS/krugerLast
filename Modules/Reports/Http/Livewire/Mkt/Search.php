<?php

namespace Modules\Reports\Http\Livewire\Mkt;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Repositories\CommissionsRepository;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralType;
use Modules\Referrals\Http\Livewire\Show\Tabs\Carriers;
use Modules\User\Entities\User;
use Auth;

class Search extends Component {

    public    $commissionsStatus;

    public    $commissionsTechs;

    public    $referralAll;

    public    $referralType;

    public    $jobTypes;

    public    $states = ['FL', 'TX', 'GA', 'LA', 'AL'];

    public    $userSelected;
    public    $userDisabled = FAlSE;

    public    $loading  = FALSE;
    public    $filters  = [
        'commission' => 'refs'
    ];

    protected $listData = [];

    public function mount()
    {
        $this->commissionsStatus = ['pending' => 'Pending', 'available' => 'Available', 'paid' => 'Paid'];
        $this->commissionsTechs  = User::where('active', 'Y')->where('group_id', '3')->get();
        $this->referralAll = Referral::all();
        $this->referralType = ReferralType::where('active', 'y')->get();

        $this->user = Auth::user();



        switch ($this->user->group_id){
            case 3:
                $this->filters['techs'] = $this->user->id;
                $this->userDisabled = TRUE;
                break;
            case 1:
                break;
            default:

            return redirect('/dashboard/list/open');
            break;

        }



        $this->jobTypes    = AssignmentsJobTypes::where('active', 'Y')->get();
    }

    public function submit()
    {

            $this->listMktRef();


    }
    protected function listMktRef()
    {
        $filters  = $this->filters;
//        $dates    = $filters['dates'] ?? ['start' => '2024-06-01', 'end' => '2024-12-31'];
        $dates    = $filters['dates'] ?? [];
//        $id       = $filters['techs'] ?? ['49'];
        $id       = $filters['techs'] ?? [];
        $referral_id = $filters['referral_id'] ?? [];
        $referral_type = $filters['referral_type'] ?? [];
        $state = $filters['state'] ?? [];

        $startDate = (new \DateTime($dates['start'] ?? 'first day of this month'))->format('Y-m-d');
        $endDate   = (new \DateTime($dates['end'] ?? 'now'))->format('Y-m-d');

        $total_commission = 0;

        $assignmnet = AssignmentFinanceRepository::without([
            'status', 'status_collection', 'event', 'phones', 'user_updated', 'user_created', 'tags', 'workers'
        ])->with(['commissions.rule'])
            ->DateSchedulledMkt($startDate, $endDate, $id, $referral_id, $state, $referral_type)
            ->whereIn('status_id', [5, 6, 10, 24, 9])
            ->get();

        $comissionsTechs = [];



        foreach ($assignmnet as $job) {

            $rules = $job->commissions->whereIn('user_id', $id);

            foreach ($rules as $rule) {

                $user     = $this->commissionsTechs->find($rule->user_id);

                $total_job  = $job->finance->invoices->total;
//                dd($job->finance);
                $total_paid= $job->finance->payments->total;
                $total_balance=$job->finance->balance->total;
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

                $referral_type= $job->referral->type->name;

                $comissionsTechs[$rule->id] = [
                    'id'             => $rule->id,
                    'user_id'        => $user->id,
                    'user_name'      => $user->name,
                    'assignment_id'  => $rule->assignment_id,
                    'status'         => $rule->status,
                    'amount'         => $rule->amount,
                    'amounts'        => $amounts,
                    'job_amount'    => $total_job,
                    'job_total_paid'    => $total_paid,
                    'job_balance'    => $total_balance,
                    'description'    => $description,
                    'address'        => $addr,
                    'referral'        => $job->referral_carrier_full,
                    'referral_type'        => $referral_type,
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


    protected function toCollectionReferral($data){
        $jobsbyReferral=$data->groupBy('referral');

        if(count($jobsbyReferral) > 0) {



            foreach ($jobsbyReferral as $ref_name => $jobs) {

                $total = count($jobs);


                    $ref_type=$jobs[0]['referral_type'];
//                $countType = $item->groupBy('comission_type')->map->count();
                $total_bill = $jobs->sum('job_amount');
                $total_paid = $jobs->sum('job_total_paid');
                $total_balance = $jobs->sum('job_balance');
                $total_comission = number_format($jobs->sum('amount'), 2, '.', ',');
                $total_bill     = number_format($total_bill, 2, '.', ',');
                $total_paid     = number_format($total_paid, 2, '.', ',');
                $total_balance     = number_format($total_balance, 2, '.', ',');

                $coll[rand(1, 10000000)] = [
                    'total' => $total,
                    'jobs' => $jobs,
                    'ref' => $ref_name,
                    'referral_type' => $ref_type,
                    'total_commission' => $total_comission,
                    'total_bill' => $total_bill,
                    'total_paid' => $total_paid,
                    'total_balance' => $total_balance,
                ];
                $ref_type="";

            }
            $coll = collect($coll);
        }else{
            $coll = [];

        }
        return $coll;


    }
    protected function toCollection($data)
    {

        if (empty($data)) {
            return [];
        }


        $collection = $data->groupBy('user_id')->map(function($item, $key) {

            $item    = collect($item);
            $collect = collect();

            $refs=$this->toCollectionReferral($item);
            $refs=collect($refs);
            $total_bill = $item->sum('job_amount');
            $total_paid = $item->sum('job_total_paid');
            $total_balance = $item->sum('job_balance');

            $countType = $item->groupBy('comission_type')->map->count();

            $commissions                     = $item->groupBy('status')->map(fn ($item, $key) => $item->sum('amount'));
            $commissions['total']            = number_format($total_bill, 2, '.', ',');
            $commissions['total_commission'] = number_format($item->sum('amount'), 2, '.', ',');
            $commissions['total_bill']       = number_format($total_bill, 2, '.', ',');
            $commissions['total_paid']       = number_format($total_paid, 2, '.', ',');
            $commissions['total_balance']       = number_format($total_balance, 2, '.', ',');
            $commissions['total_count']      = $countType;

            $collect['tech']        = $this->commissionsTechs->firstWhere('id', $key);
            $collect['commissions'] = $commissions;
            $collect['assignments'] = $item;
            $collect['refs'] = $refs;

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
//        dump($this->listData);
        return view('reports::livewire.mkt.search', [
            'listData' => $this->listData,
        ]);
    }

}