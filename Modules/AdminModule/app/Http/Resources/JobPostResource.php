<?php

namespace Modules\AdminModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobPostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'recruiter_id' => $this->recruiter_id,
            'job_title' => $this->job_title ?? null,
            'job_description' => $this->job_description,
            'job_requirements' => $this->job_requirements,
            'job_location' => $this->job_location,
            'job_type' => $this->job_type,
            'salary_range' => $this->salary_range,
            'status' => $this->status,
            'company_name' => $this->recruiters?->company_name,
        ];
    }
}
