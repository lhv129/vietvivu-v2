<?php

namespace App\Http\Requests\PropertyType;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreatePropertyTypeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('property_types', 'name')->withoutTrashed()
            ],
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên loại chỗ ở là bắt buộc',

            'name.string' => 'Tên loại chỗ ở phải là chuỗi',

            'name.max' => 'Tên loại chỗ ở tối đa 255 ký tự',

            'name.unique' => 'Tên loại chỗ ở đã tồn tại',

            'is_active.boolean' => 'Trạng thái không hợp lệ',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',

            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',

        ];
    }
}
