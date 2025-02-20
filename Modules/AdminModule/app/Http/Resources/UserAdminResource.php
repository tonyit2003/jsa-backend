<?php

namespace Modules\AdminModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'full_name' => $this->full_name ?? null,
            'phone_number' => $this->phone_number,
        ];
    }
}
