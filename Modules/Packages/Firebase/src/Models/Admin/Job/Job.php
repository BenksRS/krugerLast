<?php

namespace Callkruger\Api\Models\Admin\Job;

use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\HasResources;
use Callkruger\Api\Support\Traits\Relations\RelationService;
use Illuminate\Database\Eloquent\Builder;

class  Job extends ApiModel {

    use RelationService;

    protected $fillable   = ['status', 'nojob_info'];

    public    $timestamps = FALSE;

    public    $provider   = 'jobs';

    protected $casts      = [
        'id_assignment'        => 'int',
        'id_employee'          => 'int',
        'total_authorizations' => 'int',
    ];

    protected $dates      = [
        'create_date',
        'scheduled_order',
    ];

    public function getDocusignSentAttribute ($value)
    {
        return !($value == 'No' || $value == NULL);
    }

    public function scopeStatus ($query)
    {
        $status = ['scheduled', 'in_progress'];

        return $query->whereIn('new_status', $status);
    }

    public function scopeNotSynced (Builder $query)
    {
        $status = ['scheduled'];

        return $query->whereIn('new_status', $status)->doesntHave('sync');
    }

}
