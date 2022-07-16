<?php

namespace Callkruger\Api\Models\Admin;

use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\Relations\RelationService;

class Signature extends ApiModel {

    use RelationService;

    protected $fillable   = ['img_id', 'b64', 'assignment_id', 'uploaded_at'];

    public    $timestamps = FALSE;

    protected $provider   = 'signatures';


}
