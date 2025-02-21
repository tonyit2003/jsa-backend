<?php

namespace Modules\JobModule\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class JobPostDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'job_post_id' => $this->id,
            'job_title'     => $this->job_title,
            'job_description'     => $this->job_description,
            'job_requirements'     => $this->job_requirements,
            'job_location'  => $this->job_location,
            'job_type'  => $this->job_type,
            'salary_range'  => $this->salary_range,
            'created_at'  => $this->created_at,
            'company_name'  => $this->recruiters->company_name,
            'company_description'  => $this->recruiters->company_description,
            'company_website'  => $this->recruiters->company_website,
        ];
    }
}
