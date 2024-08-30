<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;
    protected $table='gallery';
    protected $with     = ['category'];
    protected $fillable = [
        'assignment_id',
        'category_id',
        'created_by',
        'updated_by',
        'img_id',
        'b64',
        'type',
        'label',
    ];


    public function category()
    {
        return $this->hasOne(GalleryCategory::class,'id','category_id');
    }
    public function getCreatedDateAttribute (){

        $return = "-";
        if($this->created_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d/Y g:i A');
        }
        return $return;
    }

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\GalleryFactory::new();
    }
}
