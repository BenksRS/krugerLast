<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class JobReportTarpSizes extends Model
{
    use HasFactory;
    protected $table = 'job_report_tarp_sizes';
    protected $fillable = [
        'width',
        'height',
        'qty',
        'stock_id',
        'job_type_id',
        'assignment_id'
    ];
    protected $appends  = [
        'sqft'
    ];

    public function stock()
    {
        return $this->belongsTo(StockTarps::class,'stock_id','id');
    }
    public function getSqftAttribute ()
    {

        $sqft = (($this->width * $this->height)*$this->qty);
        return $sqft;
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\JobReportTarpSizesFactory::new();
    }
}
