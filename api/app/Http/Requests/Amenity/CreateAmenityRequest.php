<?php

namespace App\Http\Requests\Amenity;

use App\Http\Requests\BaseRequest;

class CreateAmenityRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:amenities,name',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên tiện ích là bắt buộc',

            'name.string' => 'Tên tiện ích phải là chuỗi',

            'name.max' => 'Tên tiện ích tối đa 255 ký tự',

            'name.unique' => 'Tên tiện ích đã tồn tại',

            'is_active.boolean' => 'Trạng thái không hợp lệ',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',

            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',

        ];
    }
}
