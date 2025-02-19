<?php

namespace Modules\AdminModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCandidateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'resume' => $this->candidateProfile->resume ?? null, // Lấy từ quan hệ
            'skills' => $this->candidateProfile->skills ?? null,
            'experience' => $this->candidateProfile->experience ?? null,
            'education' => $this->candidateProfile->education ?? null,
        ];
    }
}
