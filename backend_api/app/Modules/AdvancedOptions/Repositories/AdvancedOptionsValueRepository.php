<?php

namespace App\Modules\AdvancedOptions\Repositories;

use App\Modules\AdvancedOptions\Models\AdvancedOptionsValueModel;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class AdvancedOptionsValueRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->query = AdvancedOptionsValueModel::query();
    }


    public function forObject(Model $object, $type = '')
    {
        $options_id = (new AdvancedOptionsRepository())
            ->forClass(get_class($object))
            ->type($type)
            ->get()->pluck('id');
        $this->query
            ->whereIn('advanced_options_id', $options_id)
            ->where('commentable_id', $object->id);
        return $this;
    }


}