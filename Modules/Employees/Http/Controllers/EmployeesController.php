<?php

namespace Modules\Employees\Http\Controllers;

use Callkruger\Api\Models\Admin\Worker;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Entities\JobReportReports;
use Modules\Assignments\Entities\JobReportTarpSizes;
use Modules\Assignments\Entities\JobReportWorkers;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Entities\EmployeeRules;
use Modules\Referrals\Entities\Referral;
use Modules\User\Entities\User;
use Auth;


class EmployeesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function phpinfo()
    {
        return phpinfo();
    }

    public function index()
    {
        $page_info = (object)[
            'title' => 'Employees List',
            'url_base' => 'employees',
            'back' => url('employees'),
            'back_title' => 'Employees List'
        ];
        \session()->flash('page', $page_info);
        $page = \session()->get('page');

        return view('employees::index', compact('page'));
    }
    public function profile()
    {

        $userLoged = Auth::user();
        $user = User::findOrFail($userLoged->id);
        $url =  Route::getCurrentRoute()->uri();
        $page_info = (object)[
            'title' => 'Employee Information',
            'url_base' => 'profile',
            'back' => url('#'),
            'back_title' => 'Employee List'
        ];
        \session()->flash('page', $page_info);
        //        \session()->flash('url',$url);
        \session()->put('url', $url);
        $page = \session()->get('page');

        return view('employees::livewire.profile.show', compact('user', 'page'));
    }
    public function docs()
    {
        $page_info = (object)[
            'title' => 'Employees List',
            'url_base' => 'employees_docs',
            'back' => url('employees'),
            'back_title' => 'Employees List'
        ];
        \session()->flash('page', $page_info);
        $page = \session()->get('page');

        return view('employees::index', compact('page'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function upload(Request $request)
    {
        //        dd($request);
        $image = $request->file('file');
        //
        //        $imageName = time().'.'.$image->extension();
        return response()->json(['success' => $image]);


        //        return view('livewire:employees::show.tabs.receipts.upload');
    }
    public function create()
    {
        return view('employees::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $url =  Route::getCurrentRoute()->uri();

        $page_info = (object)[
            'title' => 'Employee Information',
            'back' => url('employees'),
            'back_title' => 'Employee List'
        ];
        \session()->flash('page', $page_info);
        \session()->put('url', $url);
        $page = \session()->get('page');

        return view('employees::livewire.show.show', compact('user', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('employees::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    public function check_null($var)
    {
        if (is_null($var) || empty($var)) {
            return null;
        } else {
            return $var;
        }
    }
    public function rules()
    {
        $base_path = "DB/1/";
        $file_open = fopen(base_path("$base_path/route_comissions.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                switch ($data['1']) {
                    case 1:
                        $user_id = 1;
                        break;
                    case 4:
                        $user_id = 8;
                        break;
                    case 13:
                        $user_id = 4;
                        break;
                    case 15:
                        $user_id = 10;
                        break;
                    case 17:
                        $user_id = 16;
                        break;
                    case 20:
                        $user_id = 19;
                        break;
                    case 21:
                        $user_id = 24;
                        break;
                    case 26:
                        $user_id = 38;
                        break;
                    case 27:
                        $user_id = 39;
                        break;
                    case 29:
                        $user_id = 32;
                        break;
                    case 30:
                        $user_id = 31;
                        break;
                    case 31:
                        $user_id = 37;
                        break;
                    case 34:
                        $user_id = 34;
                        break;
                    case 35:
                        $user_id = 35;
                        break;
                    case 43:
                        $user_id = 48;
                        break;
                    case 44:
                        $user_id = 49;
                        break;
                    case 45:
                        $user_id = 50;
                        break;
                    case 48:
                        $user_id = 54;
                        break;
                    case 49:
                        $user_id = 55;
                        break;
                    case 51:
                        $user_id = 57;
                        break;
                    case 52:
                        $user_id = 58;
                        break;
                    case 55:
                        $user_id = 61;
                        break;
                    case 56:
                        $user_id = 62;
                        break;
                    case 58:
                        $user_id = 72;
                        break;
                    case 59:
                        $user_id = 63;
                        break;
                    case 60:
                        $user_id = 71;
                        break;
                    case 61:
                        $user_id = 76;
                        break;
                }

                $referral_id = $this->check_null($data['4']);
                $sq_min = $this->check_null($data['12']);
                $sq_max = $this->check_null($data['13']);
                $job_type = $this->check_null($data['14']);

                $end_date = $this->check_null($data['3']);
                $valor = $this->check_null($data['8']);
                $percentage = $this->check_null($data['6']);
                $dividir = $this->check_null($data['7']);
                if (is_null($valor)) {
                    $valor = 0.00;
                }
                if (is_null($dividir)) {
                    $dividir = 1;
                }
                if (is_null($percentage)) {
                    $percentage = 0.00;
                }
                $status = 'active';
                if (isset($end_date) && $end_date < Carbon::now()) {
                    $status = 'disable';
                }

                $rule = EmployeeRules::find($data['0']);
                if ($rule) {
                    $insert = [
                        'id' => $data['0'],
                        'user_id' => $user_id,
                        'start_date' => $data['2'],
                        'end_date' => $end_date,
                        'referral_id' => $referral_id,
                        'tech_ids' => $data['5'],
                        'porcentagem' => $percentage,
                        'dividir' => $dividir,
                        'valor' => $valor,
                        'type' => $data['9'],
                        'status' => $status,
                        'sq_min' => $sq_min,
                        'sq_max' => $sq_max,
                        'job_type' => $job_type,
                    ];

                    $rule->update($insert);
                } else {
                    $insert = [
                        'id' => $data['0'],
                        'user_id' => $user_id,
                        'start_date' => $data['2'],
                        'end_date' => $end_date,
                        'referral_id' => $referral_id,
                        'tech_ids' => $data['5'],
                        'porcentagem' => $percentage,
                        'dividir' => $dividir,
                        'valor' => $valor,
                        'type' => $data['9'],
                        'status' => $status,
                        'sq_min' => $sq_min,
                        'sq_max' => $sq_max,
                        'job_type' => $job_type,
                    ];

                    EmployeeRules::insert($insert);
                }
            }
            $firstline = false;
        }
        fclose($file_open);
    }
    public function commissions()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
        $base_path = "DB/1/";
        $file_open = fopen(base_path("$base_path/comission_balances.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 2000, ",")) !== FALSE) {
            if (!$firstline) {


                switch ($data['1']) {
                    case 1:
                        $user_id = 1;
                        break;
                    case 4:
                        $user_id = 8;
                        break;
                    case 13:
                        $user_id = 4;
                        break;
                    case 15:
                        $user_id = 10;
                        break;
                    case 17:
                        $user_id = 16;
                        break;
                    case 20:
                        $user_id = 19;
                        break;
                    case 21:
                        $user_id = 24;
                        break;
                    case 26:
                        $user_id = 38;
                        break;
                    case 27:
                        $user_id = 39;
                        break;
                    case 29:
                        $user_id = 32;
                        break;
                    case 30:
                        $user_id = 31;
                        break;
                    case 31:
                        $user_id = 37;
                        break;
                    case 34:
                        $user_id = 34;
                        break;
                    case 35:
                        $user_id = 35;
                        break;
                    case 43:
                        $user_id = 48;
                        break;
                    case 44:
                        $user_id = 49;
                        break;
                    case 45:
                        $user_id = 50;
                        break;
                    case 48:
                        $user_id = 54;
                        break;
                    case 49:
                        $user_id = 55;
                        break;
                    case 51:
                        $user_id = 57;
                        break;
                    case 52:
                        $user_id = 58;
                        break;
                    case 55:
                        $user_id = 61;
                        break;
                    case 56:
                        $user_id = 62;
                        break;
                    case 58:
                        $user_id = 72;
                        break;
                    case 59:
                        $user_id = 63;
                        break;
                    case 60:
                        $user_id = 71;
                        break;
                    case 61:
                        $user_id = 76;
                        break;
                }


                $job_type = $this->check_null($data['3']);


                $valor = $this->check_null($data['4']);
                $payroll_id = $this->check_null($data['10']);
                if ($job_type == 'JOB') {
                    $job_type = null;
                }
                if (is_null($valor)) {
                    $valor = 0.00;
                }

                $rule = EmployeeCommissions::find($data['0']);
                if ($rule) {
                    $insert = [
                        'id' => $data['0'],
                        'user_id' => $user_id,
                        'assignment_id' => $data['2'],
                        'job_type' => $job_type,
                        'amount' => $valor,
                        'status' => $data['5'],
                        'rule_id' => $data['6'],
                        'due_month' => $data['7'],
                        'due_year' => $data['8'],
                        'payroll_id' => $payroll_id,
                    ];

                    $rule->update($insert);
                } else {
                    $insert = [
                        'id' => $data['0'],
                        'user_id' => $user_id,
                        'assignment_id' => $data['2'],
                        'job_type' => $job_type,
                        'amount' => $valor,
                        'status' => $data['5'],
                        'rule_id' => $data['6'],
                        'due_month' => $data['7'],
                        'due_year' => $data['8'],
                        'payroll_id' => $payroll_id,
                    ];
                    EmployeeCommissions::insert($insert);
                }
            }
            $firstline = false;
        }
        fclose($file_open);
    }




    public function guia()
    {
        $assignmnet = AssignmentFinanceRepository::DateSchedulled('2022-01-01', Carbon::now())->whereIn('status_id', [5, 6, 10, 24, 9])->where('id', '>', 29811)->get();
        foreach ($assignmnet as $row) {
            dump($row->id);
        }
    }
    public function script_comission()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8512M');

        $assignmnet = AssignmentFinanceRepository::DateSchedulled('2021-01-01', Carbon::now())->whereIn('status_id', [5, 6, 10, 24, 9])->get();

        foreach ($assignmnet as $row) {

            try {
                $this->check_comission($row->id);
            } catch (Exception $e) {
                dump($e->getMessage());
            }
        }
    }
    public function check_comission($id)
    {
        //        dd('foi');

        Log::channel('commissions')->info("Start $id");
        //        dump("Start $id");
        $this->comission_workers_rules($id);

        $this->comission_technician_rules($id);
        $this->comission_technician_tree_rules($id);
        $this->comission_technician_no_tree_rules($id);

        $this->comission_marketing_rules($id);
        $this->comission_marketing_state_rules($id);

        $this->comission_marketing_carrier_rules($id);

        $this->comission_marketing_carrier_state_rules($id);

        $this->comission_jobs_rules($id);

        Log::channel('commissions')->info("end $id");

        //        return redirect('assignment/show/' . $id);

    }


    public function comission_technician_rules($id)
    {

        $assignment = AssignmentFinanceRepository::find($id);
        $workers = JobReportWorkers::where('assignment_id', $id)->pluck('worker_id')->toArray();

        $rulles = EmployeeRules::whereIn('user_id', $workers)
            ->where('type', 'T')
            ->get();

        $technicians = array();
        foreach ($rulles as $rulle) {

            $tech = explode(',', $rulle->tech_ids);
            foreach ($tech as $t) {
                $technicians[] = $t;
            }
        }
        $technicians = array_unique($technicians);
        $full_rulles = EmployeeRules::whereIn('user_id', $technicians)
            ->where('type', 'T')
            ->get();

        foreach ($full_rulles as $f_rulle) {

            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $f_rulle->start_date)) ? TRUE : FALSE;


            if (is_null($f_rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($f_rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                $this->apply_comission_rule($f_rulle->id, $id, "JOB");
            }
        }
    }

    public function comission_technician_tree_rules($id)
    {

        $assignment = AssignmentFinanceRepository::find($id);
        $workers = JobReportWorkers::where('assignment_id', $id)->where('job_type_id', 11)->pluck('worker_id')->toArray();

        $rulles = EmployeeRules::whereIn('user_id', $workers)
            ->where('type', 'A')
            ->get();

        $technicians = array();
        foreach ($rulles as $rulle) {

            $tech = explode(',', $rulle->tech_ids);
            foreach ($tech as $t) {
                $technicians[] = $t;
            }
        }
        $technicians = array_unique($technicians);
        $full_rulles = EmployeeRules::whereIn('user_id', $technicians)
            ->where('type', 'A')
            ->get();

        foreach ($full_rulles as $f_rulle) {

            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $f_rulle->start_date)) ? TRUE : FALSE;


            if (is_null($f_rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($f_rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                $this->apply_comission_rule($f_rulle->id, $id, "JOB");
            }
        }
    }
    public function comission_technician_no_tree_rules($id)
    {

        $assignment = AssignmentFinanceRepository::find($id);
        $workers = JobReportWorkers::where('assignment_id', $id)->where('job_type_id','!=',11)->pluck('worker_id')->toArray();

        $rulles = EmployeeRules::whereIn('user_id', $workers)
            ->where('type', 'N')
            ->get();

        $technicians = array();
        foreach ($rulles as $rulle) {

            $tech = explode(',', $rulle->tech_ids);
            foreach ($tech as $t) {
                $technicians[] = $t;
            }
        }
        $technicians = array_unique($technicians);
        $full_rulles = EmployeeRules::whereIn('user_id', $technicians)
            ->where('type', 'N')
            ->get();

        foreach ($full_rulles as $f_rulle) {

            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $f_rulle->start_date)) ? TRUE : FALSE;


            if (is_null($f_rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($f_rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                $this->apply_comission_rule($f_rulle->id, $id, "JOB");
            }
        }
    }

    public function comission_marketing_state_rules($id)
    {
        $assignment = AssignmentFinanceRepository::find($id);

        $rulles = EmployeeRules::where('referral_id', $assignment->referral_id)->where('state', $assignment->state)
            ->where('type', 'X')
            ->get();

        foreach ($rulles as $rulle) {


            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rulle->start_date)) ? TRUE : FALSE;


            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                if ($assignment->finance->balance->total >= 0) {
                    $this->apply_comission_rule($rulle->id, $id, "JOB");
                }
            }
        }
    }
    public function comission_marketing_rules($id)
    {
        $assignment = AssignmentFinanceRepository::find($id);

        $rulles = EmployeeRules::where('referral_id', $assignment->referral_id)
            ->where('type', 'R')
            ->get();

        foreach ($rulles as $rulle) {


            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rulle->start_date)) ? TRUE : FALSE;


            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                if ($assignment->finance->balance->total >= 0) {
                    $this->apply_comission_rule($rulle->id, $id, "JOB");
                }
            }
        }
    }
    public function comission_marketing_carrier_rules($id)
    {

        $assignment = AssignmentFinanceRepository::find($id);

        $rulles = EmployeeRules::where('referral_id', $assignment->referral_id)->where('carrier_id', $assignment->carrier_id)
            ->where('type', 'C')
            ->get();

        foreach ($rulles as $rulle) {


            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rulle->start_date)) ? TRUE : FALSE;


            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                if ($assignment->finance->balance->total >= 0) {
                    $this->apply_comission_rule($rulle->id, $id, "JOB");
                }
            }
        }
    }
    public function comission_marketing_carrier_state_rules($id)
    {

        $assignment = AssignmentFinanceRepository::find($id);

        $rulles = EmployeeRules::where('referral_id', $assignment->referral_id)->where('carrier_id', $assignment->carrier_id)->where('state', $assignment->state)
            ->where('type', 'Z')
            ->get();

        foreach ($rulles as $rulle) {


            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rulle->start_date)) ? TRUE : FALSE;


            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                if ($assignment->finance->balance->total >= 0) {
                    $this->apply_comission_rule($rulle->id, $id, "JOB");
                }
            }
        }
    }

    public function comission_jobs_rules($id)
    {
        $assignment = AssignmentFinanceRepository::find($id);


        $rulles = EmployeeRules::where('type', 'P')
            ->get();

        foreach ($rulles as $rulle) {
            //            dd('aqui');
            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rulle->start_date)) ? TRUE : FALSE;
            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rulle->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

                if ($assignment->finance->balance->total >= 0) {
                    $this->apply_comission_rule($rulle->id, $id, "JOB");
                }
            }
        }
    }
    public function apply_comission_rule($rule_id, $id_assignment, $job_type_id)
    {

        $rule = EmployeeRules::find($rule_id);
        $assignment = AssignmentFinanceRepository::find($id_assignment);

        $comission = EmployeeCommissions::where('assignment_id', $id_assignment)
            ->where('rule_id', $rule_id)
            ->where('user_id', $rule->user_id)
            ->first();
        $exist_comission = isset($comission) ? true : false;
        $status_comission_changed = array('available', 'pending');

        switch ($rule->type) {
                // S & J - this rules just for workers
            case 'S': // Square foot
            case 'J': //Job type
                // check if exist comission added
                if ($exist_comission == true) {
                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $billed_date = $assignment->finance->collection->billed_date_view;
                        $due_month = Carbon::createFromFormat('m/d/Y', $billed_date)->format('m');
                        $due_year = Carbon::createFromFormat('m/d/Y', $billed_date)->format('Y');

                        $date['user_id'] = $rule->user_id;
                        $date['assignment_id'] = $assignment->id;
                        if ($job_type_id != 'JOB') {
                            $date['job_type'] = $job_type_id;
                        }
                        $date['amount'] = $rule->valor;
                        $date['status'] = "available";
                        $date['rule_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }
                } else {
                    // insert
                    //dd($assignment->finance);
                    $billed_date = $assignment->finance->collection->billed_date_view;
                    $due_month = Carbon::createFromFormat('m/d/Y', $billed_date)->format('m');
                    $due_year = Carbon::createFromFormat('m/d/Y', $billed_date)->format('Y');

                    $date['user_id'] = $rule->user_id;
                    $date['assignment_id'] = $assignment->id;
                    if ($job_type_id != 'JOB') {
                        $date['job_type'] = $job_type_id;
                    }
                    $date['amount'] = $rule->valor;
                    $date['status'] = "available";
                    $date['rule_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    EmployeeCommissions::create($date)->save();
                }

                break;

            case 'A': //Technician TREE
                if (is_null($assignment->finance->collection->paid_date)) {
                    $due_date = $assignment->finance->collection->billed_date;
                    $due_month = null;
                    $due_year = null;
                    $status = 'pending';
                    $amount = $assignment->finance->invoices->total;
                    dump($assignment->finance);

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                } else {
                    $due_date = $assignment->finance->collection->paid_date;
                    $due_month = date("m", strtotime($due_date));
                    $due_year = date("Y", strtotime($due_date));
                    $status = 'available';

                    if ($assignment->referral_id == 72) {
                        $amount = ($assignment->finance->payments->total * 0.92);
                    } else {
                        $amount = $assignment->finance->payments->total;
                    }

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                }

                if ($exist_comission == true) {
                    // insert

                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $date['user_id'] = $rule->user_id;
                        $date['assignment_id'] = $assignment->id;
                        if ($job_type_id != 'JOB') {
                            $date['job_type'] = $job_type_id;
                        }
                        $date['amount'] = $valor;
                        $date['status'] = $status;
                        $date['rule_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }
                } else {
                    $date['user_id'] = $rule->user_id;
                    $date['assignment_id'] = $assignment->id;
                    if ($job_type_id != 'JOB') {
                        $date['job_type'] = $job_type_id;
                    }
                    $date['amount'] = $valor;
                    $date['status'] = $status;
                    $date['rule_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    EmployeeCommissions::create($date)->save();
                }
                break;
            case 'N': //Technician NO TREE
                if (is_null($assignment->finance->collection->paid_date)) {
                    $due_date = $assignment->finance->collection->billed_date;
                    $due_month = null;
                    $due_year = null;
                    $status = 'pending';
                    $amount = $assignment->finance->invoices->total;

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                } else {
                    $due_date = $assignment->finance->collection->paid_date;
                    $due_month = date("m", strtotime($due_date));
                    $due_year = date("Y", strtotime($due_date));
                    $status = 'available';

                    if ($assignment->referral_id == 72) {
                        $amount = ($assignment->finance->payments->total * 0.92);
                    } else {
                        $amount = $assignment->finance->payments->total;
                    }

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                }

                if ($exist_comission == true) {
                    // insert

                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $date['user_id'] = $rule->user_id;
                        $date['assignment_id'] = $assignment->id;
                        if ($job_type_id != 'JOB') {
                            $date['job_type'] = $job_type_id;
                        }
                        $date['amount'] = $valor;
                        $date['status'] = $status;
                        $date['rule_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }
                } else {
                    $date['user_id'] = $rule->user_id;
                    $date['assignment_id'] = $assignment->id;
                    if ($job_type_id != 'JOB') {
                        $date['job_type'] = $job_type_id;
                    }
                    $date['amount'] = $valor;
                    $date['status'] = $status;
                    $date['rule_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    EmployeeCommissions::create($date)->save();
                }
                break;
            case 'T': //Technician
                if (is_null($assignment->finance->collection->paid_date)) {
                    $due_date = $assignment->finance->collection->billed_date;
                    $due_month = null;
                    $due_year = null;
                    $status = 'pending';
                    $amount = $assignment->finance->invoices->total;

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                } else {
                    $due_date = $assignment->finance->collection->paid_date;
                    $due_month = date("m", strtotime($due_date));
                    $due_year = date("Y", strtotime($due_date));
                    $status = 'available';

                    if ($assignment->referral_id == 72) {
                        $amount = ($assignment->finance->payments->total * 0.92);
                    } else {
                        $amount = $assignment->finance->payments->total;
                    }

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                }

                if ($exist_comission == true) {
                    // insert

                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $date['user_id'] = $rule->user_id;
                        $date['assignment_id'] = $assignment->id;
                        if ($job_type_id != 'JOB') {
                            $date['job_type'] = $job_type_id;
                        }
                        $date['amount'] = $valor;
                        $date['status'] = $status;
                        $date['rule_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }
                } else {
                    $date['user_id'] = $rule->user_id;
                    $date['assignment_id'] = $assignment->id;
                    if ($job_type_id != 'JOB') {
                        $date['job_type'] = $job_type_id;
                    }
                    $date['amount'] = $valor;
                    $date['status'] = $status;
                    $date['rule_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    EmployeeCommissions::create($date)->save();
                }
                break;
            case 'R': //Marketing Representative referral
            case 'Z': //Marketing Representative referral
            case 'X': //Marketing Representative referral
            case 'C': //Marketing carrier by referral
                if (is_null($assignment->finance->collection->paid_date)) {
                    $due_date = $assignment->finance->collection->billed_date;
                    $due_month = null;
                    $due_year = null;
                    $status = 'pending';

                    $amount = $assignment->finance->invoices->total;

                    $valor = (($amount * $rule->porcentagem));
                } else {
                    $due_date = $assignment->finance->collection->paid_date;
                    $due_month = date("m", strtotime($due_date));
                    $due_year = date("Y", strtotime($due_date));
                    $status = 'available';

                    if ($assignment->referral_id == 72) {
                        $amount = ($assignment->finance->payments->total * 0.92);
                    } else {
                        $amount = $assignment->finance->payments->total;
                    }
                    $valor = (($amount * $rule->porcentagem));
                }


                if ($exist_comission == true) {
                    // insert

                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $date['user_id'] = $rule->user_id;
                        $date['assignment_id'] = $assignment->id;
                        if ($job_type_id != 'JOB') {
                            $date['job_type'] = $job_type_id;
                        }

                        $date['amount'] = $valor;
                        $date['status'] = $status;
                        $date['rule_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }
                } else {
                    $date['user_id'] = $rule->user_id;
                    $date['assignment_id'] = $assignment->id;
                    if ($job_type_id != 'JOB') {
                        $date['job_type'] = $job_type_id;
                    }
                    $date['amount'] = $valor;
                    $date['status'] = $status;
                    $date['rule_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    EmployeeCommissions::create($date)->save();
                }


                break;
            case 'P': //All Jobs
                if (is_null($assignment->finance->collection->paid_date)) {

                    if ($assignment->status_id == 6) {
                        $due_date = $assignment->finance->collection->paid_date;
                        $due_month = date("m", strtotime($due_date));
                        $due_year = date("Y", strtotime($due_date));
                        $status = 'available';

                        if ($assignment->referral_id == 72) {
                            $amount = ($assignment->finance->payments->total * 0.92);
                        } else {
                            $amount = $assignment->finance->payments->total;
                        }
                        //
                        //                        $amount = $assignment->paid_amount;
                        $valor = (($amount * $rule->porcentagem));
                    } else {
                        $due_date = $assignment->finance->collection->billed_date;
                        $due_month = null;
                        $due_year = null;
                        $status = 'pending';
                        $amount = $assignment->finance->invoices->total;
                    }


                    $valor = (($amount * $rule->porcentagem));
                } else {
                    $due_date = $assignment->finance->collection->paid_date;
                    $due_month = date("m", strtotime($due_date));
                    $due_year = date("Y", strtotime($due_date));
                    $status = 'available';

                    if ($assignment->referral_id == 72) {
                        $amount = ($assignment->finance->payments->total * 0.92);
                    } else {
                        $amount = $assignment->finance->payments->total;
                    }

                    $valor = (($amount * $rule->porcentagem));
                }


                if ($exist_comission == true) {
                    // insert

                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $date['user_id'] = $rule->user_id;
                        $date['assignment_id'] = $assignment->id;
                        if ($job_type_id != 'JOB') {
                            $date['job_type'] = $job_type_id;
                        }
                        $date['amount'] = $valor;
                        $date['status'] = $status;
                        $date['rule_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }
                } else {
                    $date['user_id'] = $rule->user_id;
                    $date['assignment_id'] = $assignment->id;
                    if ($job_type_id != 'JOB') {
                        $date['job_type'] = $job_type_id;
                    }
                    $date['amount'] = $valor;
                    $date['status'] = $status;
                    $date['rule_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    EmployeeCommissions::create($date)->save();
                }
                break;
            default:
                break;
        }
    }

    public function comission_workers_rules($id)
    {

        $assignment = AssignmentFinanceRepository::find($id);
        $workers = JobReportWorkers::where('assignment_id', $id)->pluck('worker_id')->toArray();
        //sdsd
//        print_r($workers);



        $comission_types = array('J', 'S');
        $check_newtarp = array(7, 9);


        // delete comissions workers fora da lista
        //        $deletecomissions=$this->comissionbalance->where('id_assignment', $id)
        //            ->where('status','!=', 'paid')
        //            ->where('job_type','!=', 'JOB')

        //            ->whereIn('id_employee','!=',$workers)
        //            ->get();

        // check rulle comission by job type
        $job_reports = JobReport::where('assignment_id', $id)->get();
        //        dd($job_reports);

        foreach ($job_reports as $jobtype) {
            switch ($jobtype->assignment_job_type_id) {
                case '1': // ROOF TARP
                    $workers = JobReportWorkers::where('assignment_id', $id)->where('job_type_id', $jobtype->assignment_job_type_id)->pluck('worker_id')->toArray();


                    // call total sq ft area install
                    $tarp_sizes = JobReportTarpSizes::where('assignment_id', $jobtype->assignment_id)->get();
                    $square_ft_install = 0;
                    if (count($tarp_sizes) > 0) {
                        foreach ($tarp_sizes as $ts) {

                            $square_ft_install = floatval(($square_ft_install) + (((int)$ts->height * (int)$ts->width) * (int)$ts->qty));
                        }
                    }
                    //                    dd($square_ft_install);


                    // get rulles for this job type
                    $rulles_comission = EmployeeRules::whereIn('user_id', $workers)
                        ->where('type', 'S')
                        ->where('sq_min', '<=', $square_ft_install)
                        ->where('sq_max', '>=', $square_ft_install)
                        ->get();

                    //                    dd($rulles_comission);

                    if (count($rulles_comission) > 0) {
                        // aply rulles
                        foreach ($rulles_comission as $rule) {

                            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rule->start_date)) ? TRUE : FALSE;

                            if (is_null($rule->end_date)) {
                                $check_end_date = TRUE;
                            } else {
                                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rule->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;
                            }
                            if ($check_start_date === TRUE && $check_end_date === TRUE) {
                                $this->apply_comission_rule($rule->id, $id, $jobtype->assignment_job_type_id);
                            }
                        }
                    }

                    break;
                case '2':
                case '3':
                $workers = JobReportWorkers::where('assignment_id', $id)->where('job_type_id', $jobtype->assignment_job_type_id)->pluck('worker_id')->toArray();


                    //                    dd($jobtype->assignment_job_type_id);
                    $job_reports_reports = JobReportReports::where('assignment_id', $jobtype->assignment_id)->where('job_type_id', $jobtype->assignment_job_type_id)->first();
                    //                dd($job_reports_reports->report_option_id);

                    if (isset($job_reports_reports)) {


                        if (in_array($job_reports_reports->report_option_id, $check_newtarp)) {
                            //                            dd('aqui');
                            // new tarp - sqft rulle

                            // call total sq ft area install
                            $tarp_sizes = JobReportTarpSizes::where('assignment_id', $jobtype->assignment_id)->get();
                            $square_ft_install = 0;
                            if (count($tarp_sizes) > 0) {
                                foreach ($tarp_sizes as $ts) {

                                    $square_ft_install = floatval(($square_ft_install) + (((int)$ts->height * (int)$ts->width) * (int)$ts->qty));
                                }
                            }

                            // get rulles for this job type
                            $rulles_comission = EmployeeRules::whereIn('user_id', $workers)
                                ->where('type', 'S')
                                ->where('sq_min', '<=', $square_ft_install)
                                ->where('sq_max', '>=', $square_ft_install)
                                ->get();

                            if (count($rulles_comission) > 0) {
                                // aply rulles
                                foreach ($rulles_comission as $rule) {

                                    $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rule->start_date)) ? TRUE : FALSE;

                                    /*                      $check_start_date = ($assignment->scheduling->start_date > $rule->start_date) ? TRUE : FALSE;*/

                                    if (is_null($rule->end_date)) {
                                        $check_end_date = TRUE;
                                    } else {

                                        $check_end_date = (!empty($assignment->scheduling->start_date) && ($rule->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;

                                        /*              $check_end_date = ($rule->end_date >= $assignment->scheduling->start_date) ? TRUE : FALSE;*/
                                    }
                                    if ($check_start_date === TRUE && $check_end_date === TRUE) {
                                        $this->apply_comission_rule($rule->id, $id, $jobtype->assignment_job_type_id);
                                    }
                                }
                            }
                        } else {
                            // same tarp - jobtype rulle
                            $rulles_comission = EmployeeRules::whereIn('user_id', $workers)
                                ->whereIn('user_id', $workers)
                                ->where('type', 'J')
                                ->where('job_type', $jobtype->assignment_job_type_id)
                                ->get();

                            if (count($rulles_comission) > 0) {
                                // aply rulles
                                foreach ($rulles_comission as $rule) {

                                    $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rule->start_date)) ? TRUE : FALSE;

                                    /*$check_start_date = ($assignment->scheduling->start_date > $rule->start_date) ? TRUE : FALSE;*/

                                    if (is_null($rule->end_date)) {
                                        $check_end_date = TRUE;
                                    } else {

                                        $check_end_date = (!empty($assignment->scheduling->start_date) && ($rule->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;

                                        /*  $check_end_date = ($rule->end_date >= $assignment->scheduling->start_date) ? TRUE : FALSE;*/
                                    }
                                    if ($check_start_date === TRUE && $check_end_date === TRUE) {
                                        $this->apply_comission_rule($rule->id, $id, $jobtype->assignment_job_type_id);
                                    }
                                }
                            }
                        }
                    } else {
                        //                        // erro job_report option
                        //                        $job_error = $this->assignment->find($id);
                        //                        $update_info['status_comission'] = 'error on job report';
                        //
                        //                        $job_error->update($update_info);
                        //ERROR COMISSION 3

                    }


                    break;
                default:
                    $workers = JobReportWorkers::where('assignment_id', $id)->where('job_type_id', $jobtype->assignment_job_type_id)->pluck('worker_id')->toArray();

                    // get rulles for this job type
                    $rulles_comission = EmployeeRules::whereIn('user_id', $workers)
                        ->whereIn('user_id', $workers)
                        ->where('type', 'J')
                        ->where('job_type', $jobtype->assignment_job_type_id)
                        ->get();

                    if (count($rulles_comission) > 0) {
                        // aply rulles
                        foreach ($rulles_comission as $rule) {

                            $check_start_date = (!empty($assignment->scheduling->start_date) && ($assignment->scheduling->start_date > $rule->start_date)) ? TRUE : FALSE;

                            /*$check_start_date = ($assignment->scheduling->start_date > $rule->start_date) ? TRUE : FALSE;*/

                            if (is_null($rule->end_date)) {
                                $check_end_date = TRUE;
                            } else {

                                $check_end_date = (!empty($assignment->scheduling->start_date) && ($rule->end_date >= $assignment->scheduling->start_date)) ? TRUE : FALSE;

                                /*   $check_end_date = ($rule->end_date >= $assignment->scheduling->start_date) ? TRUE : FALSE;*/
                            }
                            if ($check_start_date === TRUE && $check_end_date === TRUE) {
                                $this->apply_comission_rule($rule->id, $id, $jobtype->assignment_job_type_id);
                            }
                        }
                    }
                    break;
            }
        }
    }
}
