<?php

namespace App\Modules\AdvancedOptions\Resources;

use App\Modules\Appeal\Resources\AppealResource;

class AdvancedOptionsValueResource extends AppealResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'options' => new AdvancedOptionsResource($this->advanced_options),
            'value' => $this->value['value'] ?? '',
        ];
        return $data;
    }
}
