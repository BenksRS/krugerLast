<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTarps extends Model
{
    use HasFactory;
    protected $table = 'stock_tarps';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\StockTarpsFactory::new();
    }
}
