<?php

namespace App\Modules\Owner\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OwnerUserAndSteadsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        $data['uid'] = $this->uid;
        $data['id'] = $this->id;
        $data['fullName'] = $this->nameForMyRole();
        $data['email'] = '';
        $data['general_phone'] = '';
        $data['user'] = $this->user_uid ? ['uid' => $this->user_uid] : false;
        if (\Auth::user()->ability('superAdmin', 'owner-show')) {
            $data['email'] = $this->getValue('email', '');
            $data['general_phone'] = $this->getValue('general_phone', '');
        }
        $data['steads'] = $this->steads->sortBy('stead.number', SORT_NATURAL)->map(function ($item) {
            return [
                'stead_id' => $item->id,
                'number' => $item->number,
                'proportion' => $item->pivot->proportion,
            ];
        })->values();
        return $data;
    }
}
