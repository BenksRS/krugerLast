<?php

namespace Modules\Employees\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Employees\Entities\EmployeeRules;
use Modules\Referrals\Entities\Referral;
use Modules\User\Entities\User;

class EmployeesController extends Controller
{

    public function __construct ()
    {
        $this->middleware('auth:user');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function phpinfo(){
    return phpinfo();
    }
    public function index()
    {
        $page_info = (object)[
            'title' => 'Employees List',
            'back' => url('employees'),
            'back_title' => 'Employees List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('employees::index', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function upload(Request $request){
//        dd($request);
        $image = $request->file('file');
//
//        $imageName = time().'.'.$image->extension();
        return response()->json(['success'=>$image]);


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

        $page_info = (object)[
            'title' => 'Employee Information',
            'back' => url('employees'),
            'back_title' => 'Employee List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('employees::livewire.show.show', compact('user','page'));
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
    public function check_null($var){
        if(is_null($var) || empty($var)){
            return null;
        }else{
            return $var;
        }
    }
    public function rules()
    {
        $base_path="DB/1/";
        $file_open = fopen(base_path("$base_path/route_comissions.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 2000, ",")) !== FALSE) {
            if (!$firstline) {


                switch($data['1']){
                    case 1:
                        $user_id=1;
                        break;
                    case 4:
                        $user_id=8;
                        break;
                    case 13:
                        $user_id=4;
                        break;
                    case 15:
                        $user_id=10;
                        break;
                    case 17:
                        $user_id=16;
                        break;
                    case 20:
                        $user_id=19;
                        break;
                    case 21:
                        $user_id=24;
                        break;
                    case 26:
                        $user_id=38;
                        break;
                    case 27:
                        $user_id=39;
                        break;
                    case 29:
                        $user_id=32;
                        break;
                    case 30:
                        $user_id=31;
                        break;
                    case 31:
                        $user_id=37;
                        break;
                    case 34:
                        $user_id=34;
                        break;
                    case 35:
                        $user_id=35;
                        break;
                    case 43:
                        $user_id=48;
                        break;
                    case 44:
                        $user_id=49;
                        break;
                    case 45:
                        $user_id=50;
                        break;
                    case 48:
                        $user_id=54;
                        break;
                    case 49:
                        $user_id=55;
                        break;
                    case 51:
                        $user_id=57;
                        break;
                    case 52:
                        $user_id=58;
                        break;
                    case 55:
                        $user_id=61;
                        break;
                    case 56:
                        $user_id=62;
                        break;
                    case 58:
                        $user_id=72;
                        break;
                    case 59:
                        $user_id=63;
                        break;
                    case 60:
                        $user_id=71;
                        break;
                    case 61:
                        $user_id=76;
                        break;
                }

                $referral_id=$this->check_null($data['4']);
                $sq_min=$this->check_null($data['12']);
                $sq_max=$this->check_null($data['13']);
                $job_type=$this->check_null($data['14']);

                $end_date=$this->check_null($data['3']);
                $valor=$this->check_null($data['8']);
                $percentage=$this->check_null($data['6']);
                $dividir=$this->check_null($data['7']);
                if(is_null($valor)){
                    $valor=0.00;
                }
                if(is_null($dividir)){
                    $dividir=1;
                }
                if(is_null($percentage)){
                    $percentage=0.00;
                }
                $status = 'active';
                if(isset($end_date) && $end_date < Carbon::now()){
                    $status = 'disable';
                }

                $rule = EmployeeRules::find($data['0']);
                if($rule){
                    $insert=[
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
                }else{
                    $insert=[
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
        $base_path="DB/1/";
        $file_open = fopen(base_path("$base_path/comission_balances.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 2000, ",")) !== FALSE) {
            if (!$firstline) {


                switch($data['1']){
                    case 1:
                        $user_id=1;
                        break;
                    case 4:
                        $user_id=8;
                        break;
                    case 13:
                        $user_id=4;
                        break;
                    case 15:
                        $user_id=10;
                        break;
                    case 17:
                        $user_id=16;
                        break;
                    case 20:
                        $user_id=19;
                        break;
                    case 21:
                        $user_id=24;
                        break;
                    case 26:
                        $user_id=38;
                        break;
                    case 27:
                        $user_id=39;
                        break;
                    case 29:
                        $user_id=32;
                        break;
                    case 30:
                        $user_id=31;
                        break;
                    case 31:
                        $user_id=37;
                        break;
                    case 34:
                        $user_id=34;
                        break;
                    case 35:
                        $user_id=35;
                        break;
                    case 43:
                        $user_id=48;
                        break;
                    case 44:
                        $user_id=49;
                        break;
                    case 45:
                        $user_id=50;
                        break;
                    case 48:
                        $user_id=54;
                        break;
                    case 49:
                        $user_id=55;
                        break;
                    case 51:
                        $user_id=57;
                        break;
                    case 52:
                        $user_id=58;
                        break;
                    case 55:
                        $user_id=61;
                        break;
                    case 56:
                        $user_id=62;
                        break;
                    case 58:
                        $user_id=72;
                        break;
                    case 59:
                        $user_id=63;
                        break;
                    case 60:
                        $user_id=71;
                        break;
                    case 61:
                        $user_id=76;
                        break;
                }


                $job_type=$this->check_null($data['3']);


                $valor=$this->check_null($data['4']);
                $payroll_id=$this->check_null($data['10']);
                if($job_type == 'JOB'){
                    $job_type=null;
                }
                if(is_null($valor)){
                    $valor=0.00;
                }

                $rule = EmployeeCommissions::find($data['0']);
                if($rule){
                    $insert=[
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
                }else{
                    $insert=[
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




    public function script_comission(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
        $assignmnet=AssignmentFinanceRepository::DateSchedulled('2022-01-01', Carbon::now())->whereIn('status_id', [5,6,10,24,9])->get();

        foreach ($assignmnet as $row){
            try {
                $this->check_comission($row->id);
            } catch (Exception $e) {
                dump($e->getMessage());
            }
        }


    }
    public function check_comission($id){
        dump("Start $id");
//        $this->comission_workers_rules($id);

//        $this->comission_technician_rules($id);

        $this->comission_marketing_rules($id);

        $this->comission_jobs_rules($id);

        dump("end $id");

//        return redirect('assignment/show/' . $id);

    }
    public function comission_marketing_rules($id)
    {
        $assignment = AssignmentFinanceRepository::find($id);
//dd($assignment->finance);

        $rulles = EmployeeRules::where('referral_id', $assignment->referral_id)
            ->where('type', 'R')
            ->get();

        foreach ($rulles as $rulle) {


            $check_start_date = ($assignment->scheduling->start_date > $rulle->start_date) ? TRUE : FALSE;


            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = ($rulle->end_date >= $assignment->scheduling->start_date) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {


                $this->apply_comission_rule($rulle->id, $id, "JOB");

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
            $check_start_date = ($assignment->scheduling->start_date > $rulle->start_date) ? TRUE : FALSE;


            if (is_null($rulle->end_date)) {
                $check_end_date = TRUE;
            } else {
                $check_end_date = ($rulle->end_date >= $assignment->scheduling->start_date) ? TRUE : FALSE;
            }

            if ($check_start_date === TRUE && $check_end_date === TRUE) {

//                dd('aqui');
                $this->apply_comission_rule($rulle->id, $id, "JOB");

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
            case 'S':// Square foot
            case 'J': //Job type
                // check if exist comission added
                if ($exist_comission == true) {
                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $billed_date = $assignment->billed_date;
                        $due_month = date("m", strtotime($billed_date));
                        $due_year = date("Y", strtotime($billed_date));

                        $date['id_employee'] = $rule->employ_id;
                        $date['id_assignment'] = $id_assignment;
                        $date['job_type'] = $job_type_id;
                        $date['amount'] = $rule->valor;
                        $date['status'] = "available";
                        $date['rulle_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }

                } else {
                    // insert

                    $billed_date = $assignment->billed_date;
                    $due_month = date("m", strtotime($billed_date));
                    $due_year = date("Y", strtotime($billed_date));

                    $date['id_employee'] = $rule->employ_id;
                    $date['id_assignment'] = $id_assignment;
                    $date['job_type'] = $job_type_id;
                    $date['amount'] = $rule->valor;
                    $date['status'] = "available";
                    $date['rulle_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    $insert = $this->comissionbalance->insert($date);
                }

                break;
                break;
            case 'T'://Technician

                if (is_null($assignment->paid_date)) {
                    $due_date = $assignment->billed_date;
                    $due_month = null;
                    $due_year = null;
                    $status = 'pending';
                    $amount = $assignment->billed_amount;

                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                } else {
                    $due_date = $assignment->paid_date;
                    $due_month = date("m", strtotime($due_date));
                    $due_year = date("Y", strtotime($due_date));
                    $status = 'available';

                    if($assignment->referral_id == 72){
                        $amount = ($assignment->paid_amount*0.92);
                    }else{
                        $amount = $assignment->paid_amount;
                    }


                    $valor = (($amount * $rule->porcentagem) / $rule->dividir);
                }

                if ($exist_comission == true) {
                    // insert

                    // check if might be updated
                    if (in_array($comission->status, $status_comission_changed)) {
                        $date['id_employee'] = $rule->employ_id;
                        $date['id_assignment'] = $id_assignment;
                        $date['job_type'] = $job_type_id;
                        $date['amount'] = $valor;
                        $date['status'] = $status;
                        $date['rulle_id'] = $rule->id;
                        $date['due_month'] = $due_month;
                        $date['due_year'] = $due_year;
                        $comission->update($date);
                    }

                } else {
                    $date['id_employee'] = $rule->employ_id;
                    $date['id_assignment'] = $id_assignment;
                    $date['job_type'] = $job_type_id;
                    $date['amount'] = $valor;
                    $date['status'] = $status;
                    $date['rulle_id'] = $rule->id;
                    $date['due_month'] = $due_month;
                    $date['due_year'] = $due_year;

                    $insert = $this->comissionbalance->insert($date);
                }
                break;
            case 'R'://Marketing Representative
//dd($assignment->finance);
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

                    if($assignment->referral_id == 72){
                        $amount = ($assignment->finance->payments->total*0.92);
                    }else{
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
                        if($job_type_id != 'JOB'){
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
                    if($job_type_id != 'JOB'){
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
            case 'P'://All Jobs
                if (is_null($assignment->finance->collection->paid_date)) {

                    if ($assignment->status_id == 6) {
                        $due_date = $assignment->finance->collection->paid_date;
                        $due_month = date("m", strtotime($due_date));
                        $due_year = date("Y", strtotime($due_date));
                        $status = 'available';

                        if($assignment->referral_id == 72){
                            $amount = ($assignment->finance->payments->total*0.92);
                        }else{
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

                    if($assignment->referral_id == 72){
                        $amount = ($assignment->finance->payments->total*0.92);
                    }else{
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
                        if($job_type_id != 'JOB'){
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
                    if($job_type_id != 'JOB'){
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


}
