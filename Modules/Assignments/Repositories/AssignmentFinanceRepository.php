<?php

namespace Modules\Assignments\Repositories;

use Carbon\Carbon;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Scopes\AssignmentScope;

class AssignmentFinanceRepository extends Assignment {

    use AssignmentScope;

    protected $with    =['scheduling','referral','carrier','status','status_collection','event','phones','user_updated','user_created','job_types','invoices', 'payments'];

    protected $appends = ['finance','follow_up_date', 'lien_date_view'];

    public function __construct ()
    {
        parent::__construct();
    }

    public function getFollowUpDateAttribute (){

        $return = "-";
        if($this->follow_up){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->follow_up)->format('m/d/Y');
        }
        return $return;
    }
    public function getLienDateViewAttribute (){

        $return = "-";
        if($this->lien_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->lien_date)->format('m/d/Y');
        }
        return $return;
    }
    public function getFinanceAttribute (){

        $billed_amount=$this->invoices->sum('billed_amount');
        $fee_amount=$this->invoices->sum('fee_amount');
        $discount_amount=$this->invoices->sum('discount_amount');
        $settlement_amount=$this->invoices->sum('settlement_amount');
        $total_discount=($fee_amount + $discount_amount + $settlement_amount);

        $total_invoice=($billed_amount-$total_discount);



        $total_payment=$this->payments->whereIn('payment_type',['partial_payment','total_payment'])->sum('amount');
        $total_payment_fees=$this->payments->whereIn('payment_type',['fee_payment'])->sum('amount');

//dump($total_invoice);
//dump($total_payment);
        $balance=(float)bcsub($total_invoice,$total_payment,2);

//        dump($balance);
//        dd('aqui');
        $status='billed';

        //check status
        if(isset($total_invoice)){
            // billed
//            $status=5;
            $status_collection=5;
            $status = $this->status_id;

            switch ($this->status_id){
                case 5:

                    // check paid
                    $status = ($total_invoice == $total_payment) ? 6 : $status;
                    $status_collection = ($total_invoice == $total_payment) ? 6 : $status;


                    // revise_payment
                    $status = ($total_payment > $total_invoice) ? 24 : $status;

                    // partial payment
                    $status = ($total_payment > 0 && $total_payment < $total_invoice) ? 10 : $status;
                    $status_collection = ($total_payment > 0 && $total_payment < $total_invoice) ? 10 : 5;
                    break;
                case 10: // partial_paid
                    $status = ($balance == 0) ? 6 : $status;

//@dump($status);
//@dump($total_invoice);
//@dump($total_payment);
//@dump($balance);
//                    dd($total_invoice);

                    $status_collection = 6;
                    break;
                case 24:// revise payment

                    $status = ($balance == 0) ? 6 : $status;

                    $status_collection = 6;
                    break;
                case 6:
                    // revise_payment
                    $status = ($total_payment!=$total_invoice ) ? 24 : $status;

                    $status_collection = 6;
                    break;
                case 9:
                    // check paid
                    $status = ($total_invoice == $total_payment) ? 6 : $status;
                    $status_collection = ($total_invoice == $total_payment) ? 6 : $status_collection;
                    break;

                default:
                    $status = ($total_invoice > 0 && $total_payment == 0) ? 5 : $status;
                    $status_collection=$this->status_collection_id;
                    break;
            }





            // collection info

            $billed_date=$this->invoices->min('billed_date');
            $paid_date=$this->payments->max('payment_date');
            $billed_date_view = "-";
            $payment_date_view = "-";
            if($billed_date){
                $billed_date_view = Carbon::createFromFormat('Y-m-d H:i:s', $billed_date)->format('m/d/Y');
            }
            if($paid_date){
                $payment_date_view = Carbon::createFromFormat('Y-m-d H:i:s', $paid_date)->format('m/d/Y');
            }


            if($this->scheduling){
//                $service_date=$this->scheduling->start_date;
                $service_date = new \DateTime($this->scheduling->start_date);
            }else{
                $service_date=Carbon::now();
            }



            $billed_date = new \DateTime($billed_date);


            $today=Carbon::now();
//            dd($today);
            $interval_billed = $billed_date->diff($today);
//dd($interval_billed);
            $interval_service = $service_date->diff($today);


            $days_from_billing = $interval_billed->format('%a');
            $days_from_service = $interval_service->format('%a');



            $collection=['status' =>  $status_collection];
            if(in_array($this->status_id, [5,6,9,10,24]) ){
                $collection=(object)[
                    'billed_date'  =>$billed_date,
                    'billed_date_view'  =>$billed_date_view,
                    'payment_date_view'  =>$payment_date_view,
                    'days_from_billing'  =>$days_from_billing,
                    'days_from_service'  =>$days_from_service,
                    'service_date' => $service_date,
                    'paid_date' => $paid_date,
                    'status' =>  $status,
                    'status_collection' =>  $status_collection,
                ];
            }


        }else{
            // not billed
            $status='pending';
            $status_collection='waiting_billing';
            $collection=null;
        }





        $finance=(object)[
            'invoices' => (object)[
                'total' => $total_invoice,
                'all_discount' => $total_discount,
                'billed' => $billed_amount,
                'fees' => $fee_amount,
                'settlement' => $total_discount,
                'discount' => $total_discount
            ],
            'payments' => (object)[
                'total' => $total_payment,
                'fees'  => $total_payment_fees
            ],
            'balance' => (object)[
                'total' => $balance,
                'status' => $status
            ],
            'collection' => (object)$collection
        ];

        return $finance;

    }

}
//->addOrigin('456 NW 35th St, Boca Raton, FL 33431, US')