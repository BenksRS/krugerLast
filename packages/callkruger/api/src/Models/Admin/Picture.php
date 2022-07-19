<?php

namespace Callkruger\Api\Models\Admin;

use Callkruger\Api\Models\ApiModel;
use Callkruger\Api\Support\Traits\Relations\RelationService;

class Picture extends ApiModel {

    use RelationService;

    protected $fillable   = ['img_id', 'b64', 'assignment_id', 'type', 'label'];

    public    $timestamps = FALSE;

    protected $provider   = 'pictures';

/*    public function setTypeAttribute ($value)
    {
        $prefix = 'pics_';
        $value  = trim(strtolower(str_replace('pics_', '', $value)));

        switch ( $value ) {
            case 'front':
                $value = 'start_job';
            break;
            case 'pitch':
                $value = $prefix . 'before';
            break;
            default:
                $value = $prefix . $value;
            break;
        }

        $this->attributes['type'] = strtolower($value);
    }*/

}
