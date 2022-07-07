<?php

namespace Modules\Referrals\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\ReferralAuthorization;

class Referral extends Model
{
    use HasFactory;


    protected $table = 'referrals';
    protected $fillable = [
        'referral_type_id',
        'company_entity',
        'company_fictitions',
        'street',
        'city',
        'state',
        'zipcode',
        'main_contact',
        'status' ,
        'email',
        'created_at',
        'updated_at'

    ];
//    protected $with = ['type','carriers','phones'];
    protected $appends  = ['address', 'full_name'];


    public function phones()
    {
        return $this->hasMany(ReferralPhone::class,'referral_id','id')->orderBy('preferred','asc');
    }
    public function type()
    {
        return $this->belongsTo(ReferralType::class,'referral_type_id','id');
    }

    public function carriers()
    {
        return $this->belongsToMany(Referral::class,'referral_carriers_pivots','referral_vendor_id','referral_carrier_id','id')->withPivot('auth', 'default');
    }
    public function notes()
    {
        return $this->morphMany(Note::class,'notable')->orderBy('id', 'DESC');
    }
    public function authorizathions()
    {
        return $this->belongsToMany(ReferralAuthorization::class,'referral_authorization_pivots','referral_id','referral_authorizathion_id','id');
    }
//    public function authorizathionsCarriers()
//    {
//        return $this->hasMany(ReferralAuthorizations::class,'referral_id','id');
//    }


    public function getFullNameAttribute (){

        if(!empty($this->company_entity) && !empty($this->company_fictitions))
            $return = "$this->company_entity ($this->company_fictitions)";
        else{

            $return = "$this->company_entity ($this->company_fictitions)";
        }
        $entity=(!empty($this->company_entity)) ? $this->company_entity: 'No entity name';
        $fictitions=(!empty($this->company_fictitions)) ?" ($this->company_fictitions) ": '';

        $return = "$entity $fictitions";

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

    protected static function newFactory()
    {
        return \Modules\Referrals\Database\factories\ReferralFactory::new();
    }
}
