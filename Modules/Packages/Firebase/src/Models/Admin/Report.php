<?php

namespace Callkruger\Api\Models\Admin;

use Callkruger\Api\Models\Admin\Report\TarpSize;
use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\Relations\RelationService;

class Report extends ApiModel {

    use RelationService;

    protected $fillable      = [
        'id_assignment',
        'id_job_type',
        'service_date',
        'sandbags',
        'checklist_work',
        'job_report',
        'tarp_situation',
        'job_info',
        'created_by',
        'status',
        'workers',
        'plywood',
        'two_by_eigth',
        'two_by_twelve',
        'two_by_sixteen',
        'pitch',
    ];

    protected $with          = ['tarpSize'];

    protected $provider      = 'reports';

    public    $checkListName = [
        2 => 'tarp_alterations',
        3 => 'height_accommodation',
    ];

    public    $checkList     = [
        '--'                   => 1,
        'tarp_alterations'     => 2,
        'height_accommodation' => 3,
    ];

    protected $table         = 'job_reports';

    public function tarpSize ()
    {
        return $this->hasMany(TarpSize::class, ['id_assignment', 'id_job_type'], ['id_assignment', 'id_job_type']);
        /*        return $this->hasMany(TarpSize::class, 'id_assignment', 'id_assignment');*/
    }

    public function relationships ($data = [])
    {
        if ( !empty($data['tarp_size']) ) {
            $this->tarpSize()->delete();
            $this->tarpSize()->createMany($data['tarp_size']);
        }

        return parent::relationships($data);
    }

    public function getJobReportAttribute ($value)
    {
        $collect = collect(explode(', ', $value))->map(function ($item) {
            return is_numeric($item) ? (int) $item : trim($item);
        });

        return !is_array($value) ? $value : $collect->all();
    }

    public function setJobReportAttribute ($value)
    {
        $this->attributes['job_report'] = !is_array($value) ? $value : implode(', ', $value ?? []);
    }

    public function getWorkersAttribute ($value)
    {
        $collect = collect(explode(', ', $value))->map(function ($item) {
            return is_numeric($item) ? (int) $item : trim($item);
        });

        return $collect->all();
    }

    public function setWorkersAttribute ($value)
    {
        $this->attributes['workers'] = implode(', ', $value ?? []);
    }

    public function getChecklistWorkAttribute ($value)
    {
        if ( $value ) {
            $name = $this->checkListName ?? NULL;

            $value = collect(json_decode($value, TRUE));

            return $value->map(function ($item, $key) use ($name) {
                $val = $item == 'N' ? 0 : 1;

                if ( !empty($name[$key]) ) {
                    return ['name' => $name[$key], 'value' => $val];
                }

                return NULL;
            })->filter()->values();
        }

        return NULL;
    }

    public function setChecklistWorkAttribute ($value)
    {
        $map = collect($value)->mapWithKeys(function ($item, $key) {
            $val = $item['value'] ?? $item;
            $val = $val == 0 ? 'N' : 'Y';

            return [$this->checkList[$item['name']] => $val];
        })->prepend('Y', 1)->sortKeys()->toJson();

        $this->attributes['checklist_work'] = $map;
    }

}
