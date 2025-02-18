<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                function ($attribute, $value, $fail) {
                    $strength = 0;
                    if (strlen($value) > 6) {
                        $strength += 20;
                    }
                    if (preg_match('/[A-Z]/', $value)) {
                        $strength += 20;
                    }
                    if (preg_match('/[0-9]/', $value)) {
                        $strength += 20;
                    }
                    if (preg_match('/[^A-Za-z0-9]/', $value)) {
                        $strength += 20;
                    }
                    if (strlen($value) > 10) {
                        $strength += 20;
                    }

                    if ($strength < 60) {
                        $fail('Mật khẩu không đủ mạnh. Vui lòng nhập mật khẩu có ít nhất 6 ký tự, bao gồm chữ in hoa, số và ký tự đặc biệt.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ];
    }
}
