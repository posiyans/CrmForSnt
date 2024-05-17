<?php

namespace App\Modules\AdvancedOptions\Repositories;

use App\Modules\AdvancedOptions\Models\AdvancedOptionsModel as Model;
use App\Repositories\AbstractRepository;

class AdvancedOptionsRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->query = Model::query();
    }


    public function forClass($className)
    {
        $this->query->where('commentable_type', $className);
        return $this;
    }

    public function type($type)
    {
        $this->query->where('type', $type);
        return $this;
    }


    public function forObject($objectName, $type = '')
    {
        $className = AdvancedOptionsObjectRepository::getTypeClass($objectName);
        $this->forClass($className);
        $this->type($type);
        return $this;
    }

}