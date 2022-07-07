<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $table='gallery_categories';
    protected $fillable = [];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class,'category_id','id');
    }


    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\GalleryCategoryFactory::new();
    }



}
