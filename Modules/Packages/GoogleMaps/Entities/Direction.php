<?php

namespace Modules\Packages\GoogleMaps\Entities;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model {

    protected $fillable = ['origin_desc', 'destination_desc', 'origin_id', 'destination_id', 'distance_text', 'distance_value', 'duration_text', 'duration_value',];

}