<?php

namespace Modules\Integration\Services\Firebase;

use Kreait\Firebase\Database;
use Modules\Integration\Services\ServiceInterface;

class DatabaseService implements ServiceInterface {

    /**
     * @var Database
     */
    protected $database;

    /**
     * @var Database\Reference
     */
    protected $reference;

    public function __construct (Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param $table
     *
     * @return mixed
     */
    public function reference ($table): self
    {
        $this->reference = $this->database->getReference($table);

        return $this;
    }

    /**
     * @return mixed
     */
    public function key ()
    {
        return $this->reference->getKey();
    }

    /**
     * @return mixed
     */
    public function push ($array = [])
    {
        return $this->reference->push($array);
    }

    /**
     * @param $array
     *
     * @return mixed
     */
    public function set ($array = [])
    {
        return $this->reference->set($array);
    }

    /**
     * @param $array
     *
     * @return mixed
     */
    public function update ($array = [])
    {
        return $this->reference->update($array);
    }

    /**
     * @return mixed
     */
    public function remove ()
    {
        return $this->reference->remove();
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function child ($key = NULL)
    {
        return $this->reference->getChild($key);
        return $this;
    }

    /**
     * @return mixed
     */
    public function snapshot ()
    {
        $this->reference->getSnapshot();
        return $this;
    }

    /**
     * @return mixed
     */
    public function value ()
    {
        return $this->reference->getValue();
    }

}