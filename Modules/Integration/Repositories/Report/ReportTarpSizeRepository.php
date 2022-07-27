<?php

namespace Modules\Integration\Repositories\Report;

use Modules\Assignments\Entities\JobReportTarpSizes;
use Modules\Integration\Repositories\IntegrationRepository;

class ReportTarpSizeRepository extends JobReportTarpSizes {

    use IntegrationRepository;

    public function setData ($data)
    {
        $report  = $data['report'];
        $options = $report['tarp_size'];

        return collect($options)->map(function ($option) use ($data) {
            return [
                'assignment_id' => $data['job_id'],
                'job_type_id'   => $data['job_type'],
                'stock_id'      => $option['stock'],
                'width'         => $option['width'],
                'height'        => $option['height'],
                'qty'           => $option['quantity'],
            ];
        })->all();
    }

}