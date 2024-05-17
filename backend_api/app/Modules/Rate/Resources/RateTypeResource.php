<?php

namespace App\Modules\Rate\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['rate'] = $this->currentRate ?? null;
        $data['depends'] = $this->rate_group->depends;
        $data['unit_name'] = $this->rate_group->options['unit_name'] ?? '';
        return $data;
    }
}
