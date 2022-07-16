<?php

namespace Modules\Gdrive\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class gdrive extends Model
{
    use HasFactory;
    protected $table    = 'gdrive';
    protected $fillable = [
        'assignment_id',
        'job_path',
        'kruger_pictures_path',
        'pics_front_kruger_path',
        'pics_inside_kruger_path',
        'pics_before_kruger_path',
        'pics_after_kruger_path',
        'pics_before_path',
        'pics_after_path',
        'pictures_path',
        'forms_path',
        'job_link',
        'pics_link',
        'kruger_pictures_link',
        'forms_link'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Gdrive\Database\factories\GdriveFactory::new();
    }
}
