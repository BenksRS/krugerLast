<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Employees\Entities\EmployeeCommissions;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorization;
use Modules\User\Entities\User;

class Assignment extends Model {

    use HasFactory;

    protected $table    = 'assignments';

//    protected $with     = ['referral', 'carrier', 'phones', 'authorizations', 'gallery'];

    protected $fillable = [
        'created_by',
        'updated_by',
        'referral_id',
        'carrier_id',
        'carrier_info',
        'date_of_loss',
        'date_assignment',
        'follow_up',
        'first_name',
        'last_name',
        'email',
        'street',
        'city',
        'state',
        'zipcode',
        'claim_number',
        'adjuster_info',
        'billed_by',
        'status_id',
        'lien_info',
        'lien_date',
        'event_id',
        'status_collection_id',
        'allacrity_id',
        'inside_info'
    ];

    protected $appends  = [
        'address',
        'full_name',
        'dol_date',
        'created_date',
        'start_date',
        'tech',
        'destination',
        'referral_carrier',
        'referral_carrier_full',
        'order_status'
    ];

    public function referral ()
    {
        return $this->belongsTo(Referral::class, 'referral_id', 'id');
    }

    public function carrier ()
    {
        return $this->belongsTo(Referral::class, 'carrier_id', 'id');
    }

    public function phones ()
    {
        return $this->hasMany(AssignmentsPhones::class, 'assignment_id', 'id')->orderBy('preferred', 'asc');
    }

    public function job_types ()
    {
        return $this->belongsToMany(AssignmentsJobTypes::class, 'assignments_job_types_pivot', 'assignment_id', 'assignment_job_type_id', 'id');
    }
    public function invoices()
    {
        return $this->hasMany(FinanceBilling::class, 'assignment_id', 'id')->where('type','active');
    }
    public function commissions()
    {
        return $this->hasMany(EmployeeCommissions::class, 'assignment_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(FinancePayment::class, 'assignment_id', 'id')->where('type','active');
    }

    public function status(){
        return $this->belongsTo(AssignmentsStatus::class, 'status_id', 'id');
    }
    public function status_collection(){
        return $this->belongsTo(AssignmentsStatusCollection::class, 'status_collection_id', 'id');
    }
    public function status_history ()
    {
        return $this->hasMany(AssignmentsStatusPivot::class, 'assignment_id', 'id');
    }
    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'assignment_id', 'id');
    }
    public function scheduling()
    {
        return $this->hasOne(AssignmentsScheduling::class,'assignment_id','id');
    }
    public function authorizations ()
    {
        return $this->belongsToMany(ReferralAuthorization::class, 'assignments_authorization_pivot', 'assignment_id', 'authorization_id', 'id');
    }
    public function signs ()
    {
        return $this->hasMany(Signdata::class, 'assignment_id', 'id');
    }
    public function tags ()
    {
        return $this->belongsToMany(AssignmentsTags::class, 'assignments_tags_pivot', 'assignment_id', 'tag_id', 'id');
    }

    public function notes()
    {
        return $this->morphMany(Note::class,'notable')->orderBy('id', 'DESC');
    }
    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function billed_created()
    {
        return $this->belongsTo(User::class, 'billed_by', 'id');
    }
    public function user_updated ()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function event()
    {
        return $this->belongsTo(AssignmentsEvents::class, 'event_id', 'id');
    }

    public function getFullNameAttribute (){
        return "$this->last_name, $this->first_name #($this->id)";
    }
    public function getDolDateAttribute (){

        $return = "-";
        if($this->date_of_loss){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->date_of_loss)->format('m/d/Y');
        }
        return $return;
    }

    public function getCreatedDateAttribute (){

        $return = "-";
        if($this->created_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d/Y');
        }
        return $return;
    }
    public function getAddressAttribute ()
    {
        if(empty($this->street)){
            $address=(object)[
                'message' => 'NO ADDRESS FOUND ...',
                'link' => 'javascript: void(0);',
                'target' => '_self',
            ];
        }else{

            $maps_base="https://www.google.com/maps/place/";
            $full_address = "$this->street, $this->city, $this->state - $this->zipcode";
            $trated_address = str_replace(" ", "+", $full_address);
            $maps_link="$maps_base$trated_address";
            $address=(object)[
                'message' => $full_address,
                'link' => $maps_link,
                'target' => '_blank',
            ];
        }

        return $address;
    }
    public function getDestinationAttribute (){
       return "$this->street , $this->city, $this->state $this->zipcode, US";
    }
    public function getTotalBilledAttribute (){
        $billed_amount=$this->invoices->sum('billed_amount');
        return $billed_amount;
    }



    public function getTotalBalanceAttribute (){

//        $billed_amount=$this->invoi;
//        $settlement_amount=;
//        $discount_amount=;
//        $fee_amount=;
        return '';
    }
    public function getOrderStatusAttribute ()
    {
        return $this->status->ordem;
    }
    public function getReferralCarrierAttribute (){

        $referral=$this->referral->company_entity;

        if($this->carrier){
            $carrier=$this->carrier->company_entity;

        }else{
            $carrier=$this->carrier_info;
        }
        if (strlen($referral) > 10){
            $referral=substr($referral, 0, 10). '';
        }
        if (strlen($carrier) > 10){
            $carrier=substr($carrier, 0, 10). '';
        }

        $name = "$referral / $carrier";

        return $name;
    }
    public function getReferralCarrierFullAttribute (){

        $referral=$this->referral->company_entity;

        if($this->carrier){
            $carrier=$this->carrier->company_entity;

        }else{
            $carrier=$this->carrier_info;
        }
//        if (strlen($referral) > 10){
//            $referral=substr($referral, 0, 10). '';
//        }
//        if (strlen($carrier) > 10){
//            $carrier=substr($carrier, 0, 10). '';
//        }

        $name = "$referral / $carrier";

        return $name;
    }
    public function getStartDateAttribute ()
    {
        if($this->scheduling){
            return $this->scheduling->start_date;
        }else{
            return null;
        }

    }
    public function getTechAttribute ()
    {
        if($this->scheduling){
            return $this->scheduling->tech->id;
        }else{
            return null;
        }

    }

    protected static function newFactory ()
    {
        return \Modules\Assignments\Database\factories\AssignmentFactory::new();
    }

}
