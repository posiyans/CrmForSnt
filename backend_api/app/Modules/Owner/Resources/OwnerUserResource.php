<?php

namespace App\Modules\Owner\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OwnerUserResource extends JsonResource
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
        if (\Auth::user()->ability('superAdmin', ['owner-show', 'owner-edit'])) {
            $data['email'] = $this->getValue('email', '');
            $data['general_phone'] = $this->getValue('general_phone', '');
        }
        return $data;
    }
}
