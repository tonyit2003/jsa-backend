<?php

namespace Modules\JobModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class JobPostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'job_post_id' => $this->id,
            'job_title'     => $this->job_title,
            'job_location'  => $this->job_location,
            'salary_range'  => $this->salary_range,
            'company_name'  => $this->recruiters->company_name,
        ];
    }
}
