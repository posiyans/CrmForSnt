<?php

namespace App\Modules\Search\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'title' => $this->label,
            'text' => 'Раздел меню',
            'url' => $this->path ? $this->path : '/article/list/' . $this->id,
            'date' => '',
        ];
        return $data;
    }
}
