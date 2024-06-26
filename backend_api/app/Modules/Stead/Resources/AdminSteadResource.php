<?php

namespace App\Modules\Stead\Resources;

use App\Modules\AdvancedOptions\Repositories\AdvancedOptionsValueRepository;
use App\Modules\AdvancedOptions\Resources\AdvancedOptionsValueResource;
use App\Modules\Owner\Resources\OwnerUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminSteadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $owners = $this->owners;
        $data = [];
        foreach ($owners as $owner) {
            $tmp = new OwnerUserResource($owner);
            $tmp = $tmp->resolve();
            $tmp['proportion'] = (int)$owner->pivot->proportion;
            $tmp['stead_id'] = $this->id;
            $tmp['user_uid'] = $owner->user_uid;
            $data[] = $tmp;
        }
        $rez = [
            'id' => $this->id,
            'number' => $this->number,
            'size' => $this->size,
            'owners' => $data,
        ];
        $rez['address'] = $this->options['address'] ?? null;
        $rez['kadastr'] = $this->options['kadastr'] ?? null;
        $rez['coordinates'] = $this->options['coordinates'] ?? null;
        $rez['options'] = AdvancedOptionsValueResource::collection((new AdvancedOptionsValueRepository())->forObject($this->resource, 'options')->get());
        return $rez;
    }
}
