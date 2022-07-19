<?php

namespace Callkruger\Api\Database\Observers;

use Callkruger\Api\Models\Admin\Report;

class ReportObserver {

    public function creating (Report $report)
    {
        $report->service_date = date('Y-m-d');
        $report->created_by   = 'App';
        $report->status       = 'system';
    }
}
