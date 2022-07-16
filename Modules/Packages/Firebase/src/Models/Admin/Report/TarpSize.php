<?php

namespace Callkruger\Api\Models\Admin\Report;

use Callkruger\Api\Models\Admin\Report;
use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\Relations\RelationService;

class TarpSize extends ApiModel {

    use RelationService;

    public    $timestamps = FALSE;

    protected $fillable   = [
        'heigth',
        'length',
        'value',
        'id_assignment',
        'id_job_type',
        'status',
        'stock_id'
    ];

    protected $provider   = 'tarp_size';

    public function report ()
    {
        return $this->belongsTo(Report::class, 'id_assignment', 'id_assignment');
    }

}
