<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',

            'last_name' => 'required|string|max:255',

            'job_name' => 'nullable|string|max:255|unique:users,job_name',

            'gender' => 'nullable|in:male,female,other',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',

            'confirm_password' => 'required|same:password',

            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'bgImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'count' => 'nullable|integer|min:0',

            'description' => 'nullable|string|max:2000'
        ];
    }

    public function messages(): array
    {
        return [

            'first_name.required' => 'Tên không được để trống',
            'first_name.max' => 'Tên tối đa 255 ký tự',

            'last_name.required' => 'Họ không được để trống',
            'last_name.max' => 'Họ tối đa 255 ký tự',

            'job_name.unique' => 'Tên nghề nghiệp đã tồn tại',

            'gender.in' => 'Giới tính phải là nam, nữ hoặc khác',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',

            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',

            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu',
            'confirm_password.same' => 'Xác nhận mật khẩu không khớp',

            'avatar.image' => 'Avatar phải là file ảnh',
            'avatar.mimes' => 'Avatar chỉ chấp nhận jpg, jpeg, png, webp',
            'avatar.max' => 'Avatar tối đa 2MB',

            'bg_image.image' => 'Ảnh nền phải là file ảnh',
            'bg_image.mimes' => 'Ảnh nền chỉ chấp nhận jpg, jpeg, png, webp',
            'bg_image.max' => 'Ảnh nền tối đa 4MB',

            'count.integer' => 'Count phải là số nguyên',
            'count.min' => 'Count phải >= 0',

            'description.max' => 'Mô tả tối đa 2000 ký tự'
        ];
    }
}
