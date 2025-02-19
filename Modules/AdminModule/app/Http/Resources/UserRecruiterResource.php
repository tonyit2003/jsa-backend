<?php

namespace Modules\AdminModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRecruiterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'full_name' => $this->full_name ?? null,
            'phone_number' => $this->phone_number,
            'company_name' => $this->recruiter->company_name ?? null, // Lấy từ quan hệ
            'company_description' => $this->recruiter->company_description ?? null,
            'company_website' => $this->recruiter->company_website ?? null,
        ];
    }
}
