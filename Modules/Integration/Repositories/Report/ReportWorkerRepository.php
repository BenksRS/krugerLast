<?php

namespace Modules\Integration\Repositories\Report;

use Modules\Assignments\Entities\JobReportWorkers;
use Modules\Integration\Repositories\IntegrationRepository;

class ReportWorkerRepository extends JobReportWorkers {

    use IntegrationRepository;

    protected $table = 'job_report_workers';

    public function setData ($data)
    {
        $report  = $data['report'];
        $options = $report['workers'];

        return collect($options)->map(function ($option) use ($data) {
            return [
                'worker_id'     => $option,
                'assignment_id' => $data['job_id'],
                'job_type_id'   => $data['job_type'],
            ];
        })->all();
    }

}