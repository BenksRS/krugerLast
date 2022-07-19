<?php

namespace Callkruger\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ApiConnection extends Model {

    use Notifiable;

    protected $fillable         = ['token_id', 'device_id'];

/*    protected $dispatchesEvents = [
        'saved'     => DataSaved::class,
        'retrieved' => DataSaved::class,
    ];*/

    public function token ()
    {
        return $this->belongsTo(ApiToken::class);
    }

    public function device ()
    {
        return $this->belongsTo(ApiDevice::class);
    }

}
