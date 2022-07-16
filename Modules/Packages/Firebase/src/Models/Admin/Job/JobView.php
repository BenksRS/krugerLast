<?php

namespace Callkruger\Api\Models\Admin\Job;

use Illuminate\Database\Eloquent\Model;

class JobView extends Model {

    protected $casts = [
        'id_assignment'        => 'int',
        'id_employee'          => 'int',
        'total_authorizations' => 'int',
    ];

    protected $dates = [
        'create_date',
        'scheduled_order',
    ];

    public function getDocusignSentAttribute ($value)
    {
        return !($value == 'No' || $value == NULL);
    }

    public function scopeStatus ($query)
    {
        $status = ['scheduled'];

        return $query->whereIn('status_real', $status);
    }

}
