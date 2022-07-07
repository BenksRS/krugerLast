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

class AssignmentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');

        $base_path="DB/1/";
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Assignment::truncate();
        AssignmentsPhones::truncate();
        AssignmentsJobTypes::truncate();
        AssignmentsJobTypesPivot::truncate();
        AssignmentsStatus::truncate();
        AssignmentsStatusPivot::truncate();
        AssignmentsAuthorizathionPivot::truncate();
        AssignmentsTags::truncate();
        AssignmentsTagsPivot::truncate();
        AssignmentsEvents::truncate();
        AssignmentsEventPivot::truncate();
        AssignmentsScheduling::truncate();
        GalleryCategory::truncate();
        Gallery::truncate();
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

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //   Assignments
        $assignments_file = fopen(base_path("$base_path/db_020_assignments.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                if($data['2'] == ''){
                    $carrier_id=null;
                }else{
                    $carrier_id=$data['2'];
                }

                $assignments=[
                    "id" => $data['0'],
                    'referral_id' => $data['1'],
                    'carrier_id' => $carrier_id,
                    'carrier_info' => $data['3'],
                    'date_of_loss' => Carbon::now(),
                    'date_assignment' => Carbon::now(),
                    'first_name' =>$data['6'],
                    'last_name' => $data['7'],
                    'email' => $data['8'],
                    'street' => $data['9'],
                    'city' => $data['10'],
                    'state' => $data['11'],
                    'zipcode' => $data['12'],
                    'claim_number' => $data['13'],
                    'adjuster_info' => $data['14'],
                    'created_by' => $data['15'],
                    'updated_by' => $data['16'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),

                ];
                Assignment::insert($assignments);

            }
            $firstline = false;
        }
        fclose($assignments_file);

        $assignments_phones = [

        ];

        AssignmentsPhones::insert($assignments_phones);


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

                $assignments_job_types_pivot =[
                    'assignment_id' => $data['0'],
                    'assignment_job_type_id' => $data['1'],
                ];
                AssignmentsJobTypesPivot::insert($assignments_job_types_pivot);
            }
            $firstline = false;
        }
        fclose($assignments_job_types_pivot_file);








//

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


        //   $assignments_status_pivot
        $assignments_status_pivot_file = fopen(base_path("$base_path/db_025_assignments_status_pivot.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_status_pivot_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_status_pivot[] =[
                    'assignment_id' => $data['0'],
                    'assignment_status_id' => $data['1'],
                    'created_by' => $data['2'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $firstline = false;
        }
        fclose($assignments_status_pivot_file);


        AssignmentsStatusPivot::insert($assignments_status_pivot);


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

//        $assignments_events_pivot = [
        $assignments_events_pivot_file = fopen(base_path("$base_path/db_028_assignments_events_pivot.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_events_pivot_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_events_pivot[] =[
                    'assignment_id' => $data['0'],
                    'event_id' => $data['1'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $firstline = false;
        }
        fclose($assignments_events_pivot_file);

        AssignmentsEventPivot::insert($assignments_events_pivot);


        //db_030_assignments_scheduling
        $assignments_scheduling_file = fopen(base_path("$base_path/db_030_assignments_scheduling.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($assignments_scheduling_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $assignments_scheduling =[
                    'assignment_id' => $data['0'],
                    'tech_id' => $data['1'],
                    'created_by' => $data['2'],
                    'updated_by' => $data['3'],
                    'start_date' => $data['4'],
                    'end_date' => ($data['5'] == '') ? null : $data['5'] ,
                ];
                AssignmentsScheduling::insert($assignments_scheduling);
            }
            $firstline = false;
        }
        fclose($assignments_scheduling_file);



        $gallery_categories = [
            [
                'id' => 1,
                'name' => 'LIVING ROOM',
                'active' => 'Y',
            ],
            [
                'id' => 2,
                'name' => 'KITCHEN',
                'active' => 'Y',
            ],
            [
                'id' => 111,
                'name' => 'NOT SELECTED',
                'active' => 'Y',
            ],
        ];


        //   $gallery
        $gallery_file = fopen(base_path("$base_path/db_040_gallery.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($gallery_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $gallery[] =[
                    'assignment_id' => $data['0'],
                    'category_id' => $data['1'],
                    'created_by' => $data['2'],
                    'updated_by' => $data['3'],
                    'img_id' => $data['4'],
                    'b64' => $data['5'],
                    'type' => $data['6'],
                ];
            }
            $firstline = false;
        }

        fclose($gallery_file);

        $job_report = [];


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

        $job_report_tarp_sizes = [];


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
        $finance_billing = [];
        $finance_payment = [];







        AssignmentsAuthorizathionPivot::insert($assignments_authorizathion_pivot);
        AssignmentsTags::insert($assignments_tags);
        AssignmentsTagsPivot::insert($assignments_tags_pivot);


        AssignmentsScheduling::insert($assignments_scheduling);


        GalleryCategory::insert($gallery_categories);

        Gallery::insert($gallery);


        JobReport::insert($job_report);

        JobReportOptions::insert($job_report_options);
        JobReportOptionsPivot::insert($job_report_options_pivot);

        StockTarps::insert($stock_tarps);

        JobReportTarpSizes::insert($job_report_tarp_sizes);
        JobReportReports::insert($job_report_reports);
        JobReportWorkers::insert($job_report_workers);
        JobReportTreeSizes::insert($job_report_tree_sizes);
        JobReportServiceTime::insert($job_report_service_time);


        Signdata::insert($signdata);
        FinanceBilling::insert($finance_billing);
        FinancePayment::insert($finance_payment);
        // $this->call("OthersTableSeeder");
    }
}
