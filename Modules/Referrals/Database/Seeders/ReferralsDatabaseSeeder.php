<?php

namespace Modules\Referrals\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Assignments\Entities\AssignmentsAuthorizathionPivot;
use Modules\Referrals\Entities\FieldAuthorizations;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;
use Modules\Referrals\Entities\ReferralAuthorization;
use Modules\Referrals\Entities\ReferralBilling;
use Modules\Referrals\Entities\ReferralCarriersPivot;
use Modules\Referrals\Entities\ReferralPhone;
use Modules\Referrals\Entities\ReferralType;

class ReferralsDatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run ()
    {
        $base_path="DB/1/";

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ReferralType::truncate();
        Referral::truncate();
        ReferralPhone::truncate();
        ReferralAuthorization::truncate();
        ReferralAuthorizationPivot::truncate();
        ReferralCarriersPivot::truncate();
        ReferralBilling::truncate();
        FieldAuthorizations::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        //   REFERRAL TYPES
        $referral_types_file = fopen(base_path("$base_path/db_001_referral_types.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($referral_types_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $referral_types[] =[
                    "id" => $data['0'],
                    "name" => $data['1']
                ];
            }
            $firstline = false;
        }
        fclose($referral_types_file);

        ReferralType::insert($referral_types);

//   REFERRALS

        $referrals_file = fopen(base_path("$base_path/db_002_referrals.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($referrals_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if($data['10'] == '' || is_null($data['10']) || $data['10'] == '0000-00-00 00:00:00' ){
                    $created_at=Carbon::now();
                }else{
                    $created_at=$data['10'];
                }

                $referrals =[
                    "id" => $data['0'],
                    "referral_type_id" => $data['1'],
                    "company_entity" => $data['2'],
                    "company_fictitions" => $data['3'],
                    "street" => $data['4'],
                    "city" => $data['5'],
                    "state" => $data['6'],
                    "zipcode" => $data['7'],
                    "main_contact" => $data['8'],
                    "email" => $data['9'],
                    "created_at" => $created_at,
                    "updated_at" => $data['11']

                ];

                Referral::insert($referrals);
            }
            $firstline = false;
        }
        fclose($referrals_file);




//   REFERRALS PHONES PREFERREDS

        $referrals_phones_preferred_file = fopen(base_path("$base_path/db_003_referrals_phones_preferred.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($referrals_phones_preferred_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {


////                dd($referral);
//                if($referral){
                $referrals_phones[] =[
                        "referral_id" => $data['0'],
                        "contact" => $data['1'],
                        "phone" => $data['2'],
                        "preferred" => $data['3']
                    ];
//                }

            }
            $firstline = false;
        }
        fclose($referrals_phones_preferred_file);




        //   REFERRALS PHONES UNPREFERREDS

        $referrals_phones_unpreferred_file = fopen(base_path("$base_path/db_003_referrals_phones_unpreferred.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($referrals_phones_unpreferred_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

//                    $contact=$data['1'];
//                    $phone=$data['2'];
                $referrals_phones[] =[
                    "referral_id" => $data['0'],
                    "contact" => $data['1'],
                    "phone" => $data['2'],
                    "preferred" => $data['3']
                ];

            }
            $firstline = false;
        }
        fclose($referrals_phones_unpreferred_file);






        //   REFERRALS AUTHORIZATHIONS

        $referrals_authorizathions_file = fopen(base_path("$base_path/db_004_referrals_authorizations.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($referrals_authorizathions_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $referrals_authorizathions[] =[
                    "id" => $data['0'],
                    "name" => $data['1'],
                    "description" => $data['2'],
                    "b64" => $data['3'],
                    "active" => $data['4']
                ];
            }
            $firstline = false;
        }
        fclose($referrals_authorizathions_file);

        //   REFERRALS AUTHORIZATHIONS PIVOT

        $referrals_authorizathions_pivot_file = fopen(base_path("$base_path/db_005_referrals_authorizations_pivot.csv"), "r");
        $firstline = true;
        $random=0;
        while (($data = fgetcsv($referrals_authorizathions_pivot_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {
//                $random++;
                $referrals_authorizathions_pivot[] =[
                    "referral_id" => $data['0'],
                    "carrier_id" => $data['1'],
                    "referral_authorizathion_id" => $data['2']
                ];
            }
            $firstline = false;
        }
        fclose($referrals_authorizathions_pivot_file);

        //   $referrals_billing
        $field_referrals_billing_file = fopen(base_path("$base_path/db_007_referrals_billing.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($field_referrals_billing_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $referrals_billing[] =[
                    "referral_id" => $data['0'],
                    "days_from_billing" => $data['1'],
                    "days_from_scheduling" => $data['2'],
                    "days_from_scheduling_lien" => $data['3'],
                ];
            }
            $firstline = false;
        }
        fclose($field_referrals_billing_file);

        //   FIELD AUTHORIZATHIONS

        $field_authorizations_file = fopen(base_path("$base_path/DB_60_field_authorizations.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($field_authorizations_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $field_authorizations[] =[
                    "referral_authorizathion_id" => $data['1'],
                    "height" => $data['2'],
                    "length" => $data['3'],
                    "field" => $data['4'],
                ];
            }
            $firstline = false;
        }
        fclose($field_authorizations_file);


        //   db_010_referrals_carrier_vendor
        $referrals_carrier_vendor_file = fopen(base_path("$base_path/db_010_referrals_carrier_vendor.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($referrals_carrier_vendor_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $referrals_carrier_vendor[] =[
                    "referral_vendor_id" => $data['0'],
                    "referral_carrier_id" => $data['1'],
                ];
            }
            $firstline = false;
        }
        fclose($referrals_carrier_vendor_file);

        ReferralCarriersPivot::insert($referrals_carrier_vendor);


        //   db_010_referrals_carrier_others
        $referrals_carrier_others_file = fopen(base_path("$base_path/db_010_referrals_carrier_others.csv"), "r");
        $firstline = true;

        while (($data = fgetcsv($referrals_carrier_others_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $referrals_carrier_others[] =[
                    "referral_vendor_id" => $data['0'],
                    "referral_carrier_id" => $data['1'],
                ];
            }
            $firstline = false;
        }
        fclose($referrals_carrier_others_file);

        ReferralCarriersPivot::insert($referrals_carrier_others);



        ReferralPhone::insert($referrals_phones);
        ReferralAuthorization::insert($referrals_authorizathions);
        ReferralAuthorizationPivot::insert($referrals_authorizathions_pivot);
//        ReferralCarriersPivot::insert($referrals_carrier);
        ReferralBilling::insert($referrals_billing);
        FieldAuthorizations::insert($field_authorizations);

    }

}
