<?php

namespace Callkruger\Api\Handlers\Listeners;

use Callkruger\Api\Handlers\Events\ProviderProcessed;
use Kreait\Firebase\Database;
use ReflectionClass;
use ReflectionException;

class SyncProviderData {

    /**
     * @var Database
     */
    protected $firebase;

    /**
     * @var array
     */
    protected $event = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * SyncProviderData constructor.
     *
     * @param Database $firebase
     */
    public function __construct (Database $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * @param ProviderProcessed $event
     */
    public function handle (ProviderProcessed $event)
    {
        $this->event = $event;
        $this->data  = $event->data;

        if ( !empty($this->data['provider']) ) {
            $this->prepare($this->data['provider']);
        } else {
            foreach ( $this->data['providers'] as $provider ) {
                $this->prepare($provider);
            }
        }
    }

    protected function prepare ($provider)
    {
        try {
            $model = new ReflectionClass($provider['model']);
            $model = $model->newInstanceArgs();

            switch ( $this->data['origin'] ) {
                case 'network':
                    $this->retrievingData($provider, $model);
                break;

                default:
                    $this->savingData($provider, $model);
                break;
            }
        } catch ( ReflectionException $e ) {
        }
    }

    protected function retrievingData ($provider, $model)
    {

    }

    protected function savingData ($provider, $model)
    {
        if ( $this->data['key'] ) {
            $item = $model->find($this->data['key']);

            if ( $item ) {
                $sync     = $item->load(['sync']);
                $resource = $item->resource();
            }
        }
    }

}
