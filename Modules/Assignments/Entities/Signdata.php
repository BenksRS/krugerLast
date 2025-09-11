<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Signdata extends Model {

    use HasFactory;

    protected $table    = 'signdata';

    protected $fillable = [
        'assignment_id',
        'created_by',
        'b64',
        'type',
        'preferred',
        'date_sign',
    ];
    protected $appends  = [
        'date_signed'
    ];


    public function getDateSignedAttribute (){
        $return = "-";
        if($this->date_sign){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->date_sign)->format('m/d/Y H:i:s');
        }
        return $return;
    }
    protected static function newFactory ()
    {
        return \Modules\Assignments\Database\factories\SigndataFactory::new();
    }

}
