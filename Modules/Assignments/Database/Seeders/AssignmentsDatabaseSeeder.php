<?php

namespace Modules\Assignments\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsAuthorizathionPivot;
use Modules\Assignments\Entities\AssignmentsEventPivot;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Entities\AssignmentsJobTypesPivot;
use Modules\Assignments\Entities\AssignmentsPhones;
use Modules\Assignments\Entities\AssignmentsScheduling;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Assignments\Entities\AssignmentsStatusCollection;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Entities\AssignmentsTags;
use Modules\Assignments\Entities\AssignmentsTagsPivot;
use Modules\Assignments\Entities\FinanceBilling;
use Modules\Assignments\Entities\FinancePayment;
use Modules\Assignments\Entities\Gallery;
use Modules\Assignments\Entities\GalleryCategory;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Entities\JobReportOptions;
use Modules\Assignments\Entities\JobReportOptionsPivot;
use Modules\Assignments\Entities\JobReportReports;
use Modules\Assignments\Entities\JobReportServiceTime;
use Modules\Assignments\Entities\JobReportTarpSizes;
use Modules\Assignments\Entities\JobReportTreeSizes;
use Modules\Assignments\Entities\JobReportWorkers;
use Modules\Assignments\Entities\Signdata;
use Modules\Assignments\Entities\StockTarps;
use Modules\Notes\Entities\Note;
use Modules\User\Entities\Techs;

class AssignmentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function check_null($var){
        if(is_null($var) || empty($var)){
           return null;
        }else{
            return $var;
        }
    }
    public function run()
    {

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');

        $base_path="DB/1/";
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Assignment::truncate();
        AssignmentsStatus::truncate();
        AssignmentsStatusCollection::truncate();
        AssignmentsPhones::truncate();
        AssignmentsJobTypes::truncate();
        AssignmentsJobTypesPivot::truncate();
        AssignmentsStatus::truncate();
        AssignmentsStatusPivot::truncate();
        AssignmentsAuthorizathionPivot::truncate();
        AssignmentsTags::truncate();
        AssignmentsTagsPivot::truncate();
        AssignmentsEvents::truncate();
//        AssignmentsEventPivot::truncate();
        AssignmentsScheduling::truncate();
//        GalleryCategory::truncate();
//        Gallery::truncate();
        JobReport::truncate();
        JobReportOptions::truncate();
        JobReportOptionsPivot::truncate();
        StockTarps::truncate();
        JobReportTarpSizes::truncate();
        JobReportReports::truncate();
        JobReportWorkers::truncate();
        JobReportTreeSizes::truncate();
        JobReportServiceTime::truncate();
        Signdata::truncate();
        FinanceBilling::truncate();
        FinancePayment::truncate();
//        Techs::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //   $assignments_events
        $assignments_events_file = fopen(base_path("$base_path/db_027_assignments_events.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_events_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_events[] =[
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $firstline = false;
        }
        fclose($assignments_events_file);

        AssignmentsEvents::insert($assignments_events);


        //   $assignments_status
        $assignments_status_file = fopen(base_path("$base_path/db_018_assignments_status.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_status_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_status[] =[
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'class' => $data['2'],
                    'ordem' => $data['3'],
                    'active' => $data['4'],
                ];
            }
            $firstline = false;
        }
        fclose($assignments_status_file);

        AssignmentsStatus::insert($assignments_status);

        //   db_019_assignments_status_collections
        $assignments_status_collection_file = fopen(base_path("$base_path/db_019_assignments_status_collections.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_status_collection_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_status_collection[] =[
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'class' => $data['2'],
                    'ordem' => $data['3'],
                    'active' => $data['4'],
                ];
            }
            $firstline = false;
        }
        fclose($assignments_status_collection_file);

        AssignmentsStatusCollection::insert($assignments_status_collection);



        //   Assignments
        $assignments_file = fopen(base_path("$base_path/db_020_assignments.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {


                    $carrier_id=$this->check_null($data['2']);
                    $date_of_loss=$this->check_null($data['4']);
                    $created_at=$this->check_null($data['17']);
                    $updated_at=$this->check_null($data['18']);
                    $follow_up=$this->check_null($data['22']);
                    $status_collection=$this->check_null($data['21']);
                    if($status_collection == null){
                        $status_collection=3;
                    }

                $assignments=[
                    "id" => $data['0'],
                    'referral_id' => $data['1'],
                    'carrier_id' => $carrier_id,
                    'carrier_info' => $data['3'],
                    'date_of_loss' => $date_of_loss,
                    'date_assignment' => Carbon::now(),
                    'first_name' =>$data['6'],
                    'last_name' => $data['7'],
                    'email' => $data['8'],
                    'street' => strtoupper($data['9']),
                    'city' => strtoupper($data['10']),
                    'state' =>  strtoupper($data['11']),
                    'zipcode' => $data['12'],
                    'claim_number' => $data['13'],
                    'adjuster_info' => $data['14'],
                    'created_by' => 73,
                    'updated_by' => 73,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                    'event_id' => $data['19'],
                    'status_id' => $data['20'],
                    'status_collection_id' => $data['21'],
                    'follow_up' => $follow_up,

                ];
                Assignment::insert($assignments);

            }
            $firstline = false;
        }
        fclose($assignments_file);

//        db_021_assignments_phones_preferred
        $assignments_phones_preferred_file = fopen(base_path("$base_path/db_021_assignments_phones_preferred.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_phones_preferred_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_phones_preferred =[
                    'assignment_id' => $data['0'],
                    'contact' => $data['1'],
                    'phone' => $data['2'],
                    'preferred' => $data['3'],
                ];
                AssignmentsPhones::insert($assignments_phones_preferred);
            }
            $firstline = false;
        }
        fclose($assignments_phones_preferred_file);




        //        db_021_assignments_phones_unpreferred
        $assignments_phones_unpreferred_file = fopen(base_path("$base_path/db_021_assignments_phones_unpreferred.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_phones_unpreferred_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_phones_unpreferred =[
                    'assignment_id' => $data['0'],
                    'contact' => $data['1'],
                    'phone' => $data['2'],
                    'preferred' => $data['3'],
                ];
                AssignmentsPhones::insert($assignments_phones_unpreferred);
            }
            $firstline = false;
        }
        fclose($assignments_phones_unpreferred_file);

        $assignments_job_types = [
            [
                'id' => 1,
                'name' => 'ROOF TARP',
                'type' => 'M',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.roof-tarp',
            ],
            [
                'id' => 2,
                'name' => 'TARP INSPECTION',
                'type' => 'S',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.tarp-inspection',
            ],
            [
                'id' => 3,
                'name' => 'TARP REPAIR',
                'type' => 'S',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.tarp-repair',
            ],
            [
                'id' => 4,
                'name' => 'TARP REMOVAL',
                'type' => 'S',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.tarp-removal',
            ],
            [
                'id' => 5,
                'name' => 'WATER',
                'type' => 'M',
                'active' => 'N',
                'view' => '',
            ],
            [
                'id' => 6,
                'name' => 'DEMOLITION',
                'type' => 'M',
                'active' => 'N',
                'view' => '',
            ],
            [
                'id' => 7,
                'name' => 'LADDER ASSIST',
                'type' => 'M',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.ladder-assist',
            ],
            [
                'id' => 8,
                'name' => 'BOARD UP',
                'type' => 'M',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.board-up',
            ],
            [
                'id' => 9,
                'name' => 'FIRE CLEAN-UP',
                'type' => 'M',
                'active' => 'N',
                'view' => '',
            ],
            [
                'id' => 10,
                'name' => 'ROOF TILE REMOVAL',
                'type' => 'M',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.roof-tarp',
            ],
            [
                'id' => 11,
                'name' => 'TREE REMOVAL',
                'type' => 'M',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.tree-removal',
            ],
            [
                'id' => 12,
                'name' => 'ESTIMATE',
                'type' => 'M',
                'active' => 'N',
                'view' => '',
            ],
            [
                'id' => 13,
                'name' => 'COMPARATIVE',
                'type' => 'S',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.roof-tarp',
            ],
            [
                'id' => 14,
                'name' => 'DAMAGE ASSESSMENT',
                'type' => 'M',
                'active' => 'Y',
                'view' => 'assignments::show.tabs.job-report.roof-tarp',
            ],

        ];

        AssignmentsJobTypes::insert($assignments_job_types);

        //   assignment_job_type_id
        $assignments_job_types_pivot_file = fopen(base_path("$base_path/db_026_assignments_job_types_pivot.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_job_types_pivot_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $job_types=explode(",", $data['1']);

                foreach ($job_types as $jb){
                    $assignments_job_types_pivot =[
                        'assignment_id' => $data['0'],
                        'assignment_job_type_id' => $jb,
                    ];
                    AssignmentsJobTypesPivot::insert($assignments_job_types_pivot);
                }



            }
            $firstline = false;
        }
        fclose($assignments_job_types_pivot_file);





        //   $assignments_status_pivot
        $assignments_status_pivot_file = fopen(base_path("$base_path/db_025_assignments_status_pivot.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_status_pivot_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_status_pivot =[
                    'assignment_id' => $data['0'],
                    'assignment_status_id' => $data['1'],
                    'created_by' => $data['2'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
                AssignmentsStatusPivot::insert($assignments_status_pivot);
            }
            $firstline = false;
        }
        fclose($assignments_status_pivot_file);





        $assignments_authorizathion_pivot = [
            [
                'assignment_id' => 27870,
                'authorization_id' => 774,
            ],
            [
                'assignment_id' => 27870,
                'authorization_id' => 770,
            ],
        ];


        $assignments_tags = [
            [
                'id' => '1',
                'name' => 'SINGLE STORY',
            ],
            [
                'id' => '2',
                'name' => 'TWO STORY',
            ],
            [
                'id' => '3',
                'name' => 'STEEP ROOF',
            ],
        ];
        $assignments_tags_pivot = [
            [
                'assignment_id' => 27869,
                'tag_id' => '2',
            ],
            [
                'assignment_id' => 27870,
                'tag_id' => '3',
            ],
        ];



//        $assignments_events_pivot = [
//        $assignments_events_pivot_file = fopen(base_path("$base_path/db_028_assignments_events_pivot.csv"), "r");
//        $firstline = true;
//        while (($data = fgetcsv($assignments_events_pivot_file, 2000, ",")) !== FALSE) {
//            if (!$firstline) {
//
//                $assignments_events_pivot[] =[
//                    'assignment_id' => $data['0'],
//                    'event_id' => $data['1'],
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now(),
//                ];
//            }
//            $firstline = false;
//        }
//        fclose($assignments_events_pivot_file);
//
//        AssignmentsEventPivot::insert($assignments_events_pivot);


        //db_030_assignments_scheduling
        $assignments_scheduling_file = fopen(base_path("$base_path/db_030_assignments_scheduling.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_scheduling_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {


                $start_date=$this->check_null($data['4']);
                $end_date=$this->check_null($data['5']);
                $assignments_scheduling =[
                    'assignment_id' => $data['0'],
                    'tech_id' => $data['1'],
                    'created_by' => $data['2'],
                    'updated_by' => $data['3'],
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];
                AssignmentsScheduling::insert($assignments_scheduling);
            }
            $firstline = false;
        }
        fclose($assignments_scheduling_file);



//        $gallery_categories = [
//            [
//                'id' => 1,
//                'name' => 'LIVING ROOM',
//                'active' => 'Y',
//            ],
//            [
//                'id' => 2,
//                'name' => 'KITCHEN',
//                'active' => 'Y',
//            ],
//            [
//                'id' => 111,
//                'name' => 'NOT SELECTED',
//                'active' => 'Y',
//            ],
//        ];

//        GalleryCategory::insert($gallery_categories);
//
//        //   $gallery
//        $gallery_file = fopen(base_path("$base_path/db_040_gallery.csv"), "r");
//        $firstline = true;
//        while (($data = fgetcsv($gallery_file, 2000, ",")) !== FALSE) {
//            if (!$firstline) {
//
//
//
//
//                $gallery[] =[
//                    'assignment_id' => $data['0'],
//                    'category_id' => $data['1'],
//                    'created_by' => $data['2'],
//                    'updated_by' => $data['3'],
//                    'img_id' => $data['4'],
//                    'b64' => $data['5'],
//                    'type' => $data['6'],
//                ];
//            }
//            $firstline = false;
//        }
//
//        fclose($gallery_file);
//
//        Gallery::insert($gallery);
//
//        //$job_report
//        $job_report_file = fopen(base_path("$base_path/db_031_job_report.csv"), "r");
//        $firstline = true;
//        while (($data = fgetcsv($job_report_file, 2000, ",")) !== FALSE) {
//            if (!$firstline) {
//
//                $tarp_situation=$data['7'];
//                if($tarp_situation == 2 || $tarp_situation == 4){
//                    $tarp_situation='Y';
//                }else{
//                    $tarp_situation='N';
//                }
//
//
//                $job_report =[
//                    'assignment_id' => $data['0'],
//                    'assignment_job_type_id' => $data['1'],
//                    'service_date' => $data['2'],
//                    'pitch' => $data['3'],
//                    'sandbags' => $data['4'],
//                    'created_by' => $data['5'],
//                    'updated_by' => $data['6'],
//                    'tarp_situation' => $tarp_situation,
//                    'plywoods' => $data['8'],
//                    's2x4x8' => $data['9'],
//                    's2x4x12' => $data['10'],
//                    's2x4x16' => $data['11'],
//                    'job_info' => $data['12'],
//                ];
//                JobReport::insert($job_report);
//
//            }
//            $firstline = false;
//
//        }
//
//        fclose($job_report_file);


        $stock_tarps = [
            [
                'id' => 1,
                'name' => '20x30',
            ],
            [
                'id' => 2,
                'name' => '30x40',
            ],
            [
                'id' => 3,
                'name' => '30x50',
            ],
            [
                'id' => 4,
                'name' => '40x60',
            ],
            [
                'id' => 5,
                'name' => '30x60',
            ],
            [
                'id' => 6,
                'name' => '50x50',
            ],
            [
                'id' => 7,
                'name' => '50x100',
            ],
            [
                'id' => 8,
                'name' => '25x40',
            ],
            [
                'id' => 9,
                'name' => 'Sobras',
            ],
            [
                'id' => 10,
                'name' => 'Same Tarp',
            ],
        ];

        StockTarps::insert($stock_tarps);

//        db_032_job_report_tarp_sizes
        $job_report_tarp_sizes_file = fopen(base_path("$base_path/db_032_job_report_tarp_sizes.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($job_report_tarp_sizes_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {



                $job_report_tarp_sizes=[
                    'width' => $data['0'],
                    'height' => $data['1'],
                    'qty' => $data['2'],
                    'stock_id' => $data['3'],
                    'assignment_id' => $data['4'],
                    'job_type_id' => $data['5'],
                ];

                JobReportTarpSizes::insert($job_report_tarp_sizes);

            }
            $firstline = false;

        }
        fclose($job_report_tarp_sizes_file);






        //   $job_report_options
        $job_report_options_file = fopen(base_path("$base_path/db_035_job_report_options.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($job_report_options_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $job_report_options[] =[
                    'id' => $data['0'],
                    'name' => $data['1'],
                ];
            }
            $firstline = false;
        }
        fclose($job_report_options_file);

        JobReportOptions::insert($job_report_options);


        //   $job_report_options_pivot
        $job_report_options_pivot_file = fopen(base_path("$base_path/db_036_job_report_options_pivot.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($job_report_options_pivot_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $job_report_options_pivot[] =[
                    'report_option_id' => $data['0'],
                    'job_type_id' => $data['1'],
                ];
            }
            $firstline = false;
        }
        fclose($job_report_options_pivot_file);

        JobReportOptionsPivot::insert($job_report_options_pivot);


//        db_033_job_report_reports.cs
        $job_report_reports_file = fopen(base_path("$base_path/db_033_job_report_reports.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($job_report_reports_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $options_report=explode(',',$data['2']);
                if(count($options_report) > 0){
                    foreach ($options_report as $rowrep){
                        if($rowrep != ''){
                            $job_report_reports =[
                                'report_option_id' => $rowrep,
                                'job_type_id' => $data['1'],
                                'assignment_id' => $data['0'],
                            ];

                            JobReportReports::insert($job_report_reports);
                        }
                    }

                }
            }
            $firstline = false;
        }
        fclose($job_report_reports_file);

//             db_034_job_report_workers
        $db_034_job_report_workers_file = fopen(base_path("$base_path/db_034_job_report_workers.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($db_034_job_report_workers_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $options_report=explode(',',$data['2']);
                if(count($options_report) > 0){
                    foreach ($options_report as $rowrep){
                        if($rowrep != ''){

                            switch ($rowrep){
                                case 7: $rowrep=2; break;
                                case 4: $rowrep=8; break;
                                case 28: $rowrep=9; break;
                                case 15: $rowrep=10; break;
                                case 16: $rowrep=14; break;
                                case 20: $rowrep=19; break;
                                case 21: $rowrep=24; break;
                                case 23: $rowrep=25; break;
                                case 30: $rowrep=31; break;
                                case 29: $rowrep=32; break;
                                case 32: $rowrep=36; break;
                                case 31: $rowrep=37; break;
                                case 26: $rowrep=38; break;
                                case 27: $rowrep=39; break;
                                case 42: $rowrep=45; break;
                                case 41: $rowrep=46; break;
                                case 43: $rowrep=48; break;
                                case 46: $rowrep=51; break;
                                case 48: $rowrep=54; break;
                                case 49: $rowrep=55; break;
                                case 51: $rowrep=57; break;
                                case 52: $rowrep=58; break;
                                case 53: $rowrep=59; break;
                                case 54: $rowrep=60; break;
                                case 55: $rowrep=61; break;
                                case 56: $rowrep=62; break;
                                case 59: $rowrep=63; break;
                                case 60: $rowrep=71; break;
                                case 58: $rowrep=72; break;
                                default:
                                    $rowrep=$rowrep;
                                    break;
                            }


                            $job_report_workers =[
                                'worker_id' => $rowrep,
                                'job_type_id' => $data['1'],
                                'assignment_id' => $data['0'],
                            ];

                            JobReportWorkers::insert($job_report_workers);
                        }
                    }

                }
            }
            $firstline = false;
        }
        fclose($db_034_job_report_workers_file);


        //   db_050_signdate
        $signdata_file = fopen(base_path("$base_path/db_050_signdate.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($signdata_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $signdata[] =[
                    'assignment_id' => 27870,
                    'created_by' => $data['1'],
                    'b64' => $data['2'],
                    'type' => $data['3'],
                ];
            }
            $firstline = false;
        }
        fclose($signdata_file);



        $job_report_reports = [];
        $job_report_workers = [];
        $job_report_tree_sizes = [];
        $job_report_service_time = [];
//        $finance_billing = [];
        $finance_payment = [];
//        $techs = [];

        //   FINANCE BILLING
        $finance_billing_file = fopen(base_path("$base_path/db_100_finance_billing.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_billing_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if(empty($data['1']) || is_null($data['1'])){
                    $invoice_id='9999999';
                }else{
                    $invoice_id=$data['1'];
                }
                if(empty($data['2']) || is_null($data['2'])){
                    $billed_date = '2018-01-01';
                }else{
                    $billed_date =$data['2'];
                }

                switch ($data['8']){
                    case 'partial_paid': $status='partial_payment'; break;
                    case 'lien': $status='billed'; break;
                    default: $status=$data['8']; break;
                }

                $lien=($data['8'] == 'lien') ? 'Y' : 'N';

                $finance_billing=[
                    'assignment_id' => $data['0'],
                    'invoice_id' => $invoice_id,
                    'created_by' => 73,
                    'updated_by' => 73,
                    'billed_amount' => $data['3'],
                    'fee_amount' => $data['5'],
                    'discount_amount' => $data['6'],
                    'settlement_amount' => $data['7'],
                    'billed_date' => $billed_date,
                    'type' => 'active',
                    'status' => $status,
                    'lien' => $lien,
                ];

                FinanceBilling::insert($finance_billing);
            }
            $firstline = false;
        }
        fclose($finance_billing_file);

        //   FINANCE PAYMENT PAID FEES
        $finance_payments_paid_fees_file = fopen(base_path("$base_path/db_100_finance_payments_paid_fees.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_payments_paid_fees_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if(empty($data['1']) || is_null($data['1'])){
                    $invoice_id='9999999';
                }else{
                    $invoice_id=$data['1'];
                }
                if(empty($data['2']) || is_null($data['2'])){
                    $paid_date = '2018-01-01';
                }else{
                    $paid_date =$data['2'];
                }

                $finance_payment_fees=[
                    'assignment_id' => $data['0'],
                    'invoice_id' => $invoice_id,
                    'created_by' => 73,
                    'updated_by' => 73,
                    'amount' => $data['3'],
                    'payment_date' => $paid_date,
                    'type' => 'disable',
                    'payment_type' => 'fee_payment',
                ];

                FinancePayment::insert($finance_payment_fees);
            }
            $firstline = false;
        }
        fclose($finance_payments_paid_fees_file);

        //   FINANCE PAYMENT PAID ONE TIME
        $finance_payments_paid_file = fopen(base_path("$base_path/db_100_finance_payments_paid.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_payments_paid_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if(empty($data['1']) || is_null($data['1'])){
                    $invoice_id='9999999';
                }else{
                    $invoice_id=$data['1'];
                }
                if(empty($data['2']) || is_null($data['2'])){
                    $paid_date = '2018-01-01';
                }else{
                    $paid_date =$data['2'];
                }

                $finance_payment=[
                    'assignment_id' => $data['0'],
                    'invoice_id' => $invoice_id,
                    'created_by' => 73,
                    'updated_by' => 73,
                    'amount' => $data['3'],
                    'payment_date' => $paid_date,
                    'type' => 'active',
                    'payment_type' => 'total_payment',
                ];

                FinancePayment::insert($finance_payment);
            }
            $firstline = false;
        }
        fclose($finance_payments_paid_file);

        //   FINANCE PAYMENT PAID PARTIAL ONE
        $finance_payments_partial_one_file = fopen(base_path("$base_path/db_100_finance_payments_partial_one.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_payments_partial_one_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if(empty($data['1']) || is_null($data['1'])){
                    $invoice_id='9999999';
                }else{
                    $invoice_id=$data['1'];
                }
                if(empty($data['4']) || is_null($data['4'])){
                    $paid_date = '2018-01-01';
                }else{
                    $paid_date =$data['4'];
                }

                $finance_payment=[
                    'assignment_id' => $data['0'],
                    'invoice_id' => $invoice_id,
                    'created_by' => 73,
                    'updated_by' => 73,
                    'amount' => $data['5'],
                    'payment_date' => $paid_date,
                    'type' => 'active',
                    'payment_type' => 'partial_payment',
                ];

                FinancePayment::insert($finance_payment);
            }
            $firstline = false;
        }
        fclose($finance_payments_partial_one_file);


        //   FINANCE PAYMENT PAID PARTIAL ONE
        $finance_payments_partial_two_file = fopen(base_path("$base_path/db_100_finance_payments_partial_two.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_payments_partial_two_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if(empty($data['1']) || is_null($data['1'])){
                    $invoice_id='9999999';
                }else{
                    $invoice_id=$data['1'];
                }
                if(empty($data['6']) || is_null($data['6'])){
                    $paid_date = '2018-01-01';
                }else{
                    $paid_date =$data['6'];
                }

                $finance_payment=[
                    'assignment_id' => $data['0'],
                    'invoice_id' => $invoice_id,
                    'created_by' => 73,
                    'updated_by' => 73,
                    'amount' => $data['7'],
                    'payment_date' => $paid_date,
                    'type' => 'active',
                    'payment_type' => 'total_payment',
                ];

                FinancePayment::insert($finance_payment);
            }
            $firstline = false;
        }
        fclose($finance_payments_partial_two_file);


        //   assignments NOTES
        $assignment_notes_file = fopen(base_path("$base_path/db_110_assignments_notes.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignment_notes_file, 5000, ",")) !== FALSE) {
            if (!$firstline) {

                    if(isset($data['1'])){

                    $text=$data['1'];
                    $text=str_replace('"','',$text);
                    $text=str_replace("/\/",'',$text);

                    $assignment_notes =[
                        'text'=> $text,
                        'notable_id'=> $data['0'],
                        'created_by'=> 73,
                        'type'=> 'assignment',
                        'notable_type'=>  Assignment::class,
                    ];
                    Note::insert($assignment_notes);

                    }
                }


            $firstline = false;
        }
        fclose($assignment_notes_file);


        //   FINANCE NOTES
        $finance_notes_file = fopen(base_path("$base_path/db_110_finance_notes.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_notes_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $finance_notes =[
                    'text'=> $data['1'],
                    'notable_id'=> $data['0'],
                    'created_by'=> 73,
                    'type'=> 'finance',
                    'notable_type'=>  Assignment::class,
                ];

                Note::insert($finance_notes);
            }
            $firstline = false;
        }
        fclose($finance_notes_file);

//   FINANCE NOTES Payment
        $finance_notes_payment_file = fopen(base_path("$base_path/db_110_finance_notes_payment.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_notes_payment_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $finance_notes_payment =[
                    'text'=> $data['1'],
                    'notable_id'=> $data['0'],
                    'created_by'=> 73,
                    'type'=> 'payment',
                    'notable_type'=>  Assignment::class,
                ];

                Note::insert($finance_notes_payment);
            }
            $firstline = false;
        }
        fclose($finance_notes_payment_file);

//   FINANCE NOTES billing
        $finance_notes_billing_file = fopen(base_path("$base_path/db_110_finance_notes_billing.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($finance_notes_billing_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $finance_notes_billing =[
                    'text'=> $data['1'],
                    'notable_id'=> $data['0'],
                    'created_by'=> 73,
                    'type'=> 'billing',
                    'notable_type'=>  Assignment::class,
                ];

                Note::insert($finance_notes_billing);
            }
            $firstline = false;
        }
        fclose($finance_notes_billing_file);



        AssignmentsAuthorizathionPivot::insert($assignments_authorizathion_pivot);
        AssignmentsTags::insert($assignments_tags);
        AssignmentsTagsPivot::insert($assignments_tags_pivot);

//        AssignmentsScheduling::insert($assignments_scheduling);


        JobReportTreeSizes::insert($job_report_tree_sizes);
        JobReportServiceTime::insert($job_report_service_time);


        Signdata::insert($signdata);


        // $this->call("OthersTableSeeder");
    }
}
