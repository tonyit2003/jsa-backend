<?php

namespace Modules\JobModule\Http\Requests\CandidateProfile;

use Illuminate\Foundation\Http\FormRequest;

class CandidateProfileApplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'Vui lòng chọn công việc cần ứng tuyển.',
        ];
    }
}
