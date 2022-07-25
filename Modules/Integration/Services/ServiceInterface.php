<?php

namespace Modules\Integration\Services;

interface ServiceInterface {

    /**
     * @param $table
     *
     * @return mixed
     */
    public function reference ($table);

    /**
     * @return mixed
     */
    public function key ();

    /**
     * @return mixed
     */
    public function push ();

    /**
     * @param $array
     *
     * @return mixed
     */
    public function set ($array = []);

    /**
     * @param $array
     *
     * @return mixed
     */
    public function update ($array = []);

    /**
     * @return mixed
     */
    public function remove ();

    /**
     * @param $key
     *
     * @return mixed
     */
    public function child ($key = NULL);

    /**
     * @return mixed
     */
    public function snapshot ();

    /**
     * @return mixed
     */
    public function value ();

}