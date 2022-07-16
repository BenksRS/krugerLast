<?php

namespace Callkruger\Api\Models;

use Callkruger\Api\Handlers\Events\DataSaved;
use Callkruger\Api\Http\Resources\Token\TokenCollection;
use Callkruger\Api\Http\Resources\Token\TokenResource;
use Callkruger\Api\Support\Traits\HasResources;
use Callkruger\Api\Support\Traits\Relations\RelationService;

class ApiToken extends ApiModel {

    use HasResources;
    use RelationService;

    protected        $fillable         = ['token', 'tokenable_type', 'tokenable_id', 'request', 'status'];

    protected        $dispatchesEvents = [
        'updated' => DataSaved::class,
    ];

    protected static $apiResources     = [
        'resource'   => TokenResource::class,
        'collection' => TokenCollection::class,
    ];

    protected        $tableNames       = 'api_token';

    /**
     * Get the parent imageable model (user or post).
     */
    public function tokenable ()
    {
        return $this->morphTo();
    }

}
