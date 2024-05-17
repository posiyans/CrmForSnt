<?php

namespace App\Modules\AdvancedOptions\Resources;

use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsTypeRepository;
use App\Modules\Appeal\Resources\AppealResource;

class AdvancedOptionsResource extends AppealResource
{

    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'type_value' => [
                'key' => $this->type_value,
                'label' => AdvancedOptionsTypeRepository::getTypeLabel($this->type_value)
            ],
            'options' => $this->options,
        ];
        return $data;
    }
}
