<?php

namespace App\Repositories;


abstract class AbstractRepository
{
    protected $query;

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array(array($this->query, $name), $arguments);
    }


}