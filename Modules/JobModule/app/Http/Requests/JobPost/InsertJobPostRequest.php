<?php

namespace Modules\JobModule\Http\Requests\JobPost;

use Illuminate\Foundation\Http\FormRequest;

class InsertJobPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_title'        => 'required',
            'job_description'  => 'required',
            'job_requirements' => 'required',
            'job_location'     => 'required',
            'job_type'         => 'required|in:full-time,part-time,contract,internship',
            'salary_range'     => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'job_title.required'        => 'Vui lòng nhập tiêu đề công việc.',
            'job_description.required'  => 'Vui lòng nhập mô tả công việc.',
            'job_requirements.required' => 'Vui lòng nhập yêu cầu công việc.',
            'job_location.required'     => 'Vui lòng nhập địa điểm làm việc.',
            'job_type.required'         => 'Vui lòng chọn loại công việc.',
            'job_type.in'             => 'Loại công việc không hợp lệ.',
            'salary_range.required'     => 'Vui lòng nhập mức lương.',
        ];
    }
}
