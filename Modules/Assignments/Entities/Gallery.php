<?php

namespace Modules\Assignments\Entities;

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
    ];


    public function category()
    {
        return $this->hasOne(GalleryCategory::class,'id','category_id');
    }

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\GalleryFactory::new();
    }
}
