<?php

namespace Modules\Integration\Repositories\Report;

use Modules\Assignments\Entities\JobReportReports;
use Modules\Integration\Repositories\IntegrationRepository;

class ReportReportRepository extends JobReportReports {

    use IntegrationRepository;

    protected $table = 'job_report_reports';

    public function setData ($data)
    {
        $report  = $data['report'];
        $options = $report['report_options'];

        return collect($options)->map(function ($option) use ($data) {
            return [
                'report_option_id' => $option,
                'assignment_id'    => $data['job_id'],
                'job_type_id'      => $data['job_type'],
            ];
        })->all();
    }

}