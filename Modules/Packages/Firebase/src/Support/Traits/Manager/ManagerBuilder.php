<?php

namespace Callkruger\Api\Support\Traits\Manager;

trait ManagerBuilder {

    protected $data    = [];

    protected $builder = [];

    public function set (array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function where (array $query = [])
    {
        $this->builder[] = ['type' => 'where', 'query' => $query];

        return $this;
    }

    public function orWhere (array $query = [])
    {
        $this->builder[] = ['type' => 'orWhere', 'query' => $query];

        return $this;
    }

}
