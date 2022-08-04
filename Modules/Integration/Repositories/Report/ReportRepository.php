<?php

namespace Modules\Integration\Repositories\Report;

use Illuminate\Database\Eloquent\Model;
use Modules\Assignments\Entities\JobReport;
use Modules\Integration\Repositories\IntegrationRepository;

class ReportRepository extends JobReport {

    use IntegrationRepository;

    public function setData ($data)
    {
        $report    = $data['report'];
        $checklist = $report['checklist'] ?? [];
        $elements  = $report['elements'];

        $checklist = collect($checklist)->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value'] == 0 ? 'N' : 'Y'];
        })->all();

        return array_merge([
            'service_date'           => date('Y-m-d 00:00:00'),
            'assignment_id'          => $data['job_id'],
            'assignment_job_type_id' => $data['job_type'],
            'pitch'                  => !empty($elements['pitch']) ? $elements['pitch'] . '/12' : NULL,
            'sandbags'               => $elements['sandbags'] ?? NULL,
            'job_info'               => $elements['infos'] ?? NULL,
            'plywoods'               => $elements['plywood'] ?? NULL,
            's2x4x8'                 => $elements['two_by_eigth'] ?? NULL,
            's2x4x12'                => $elements['two_by_twelve'] ?? NULL,
            's2x4x16'                => $elements['two_by_sixteen'] ?? NULL,
            'created_by'             => 73,
            'updated_by'             => 73,
        ], $checklist);
    }

}