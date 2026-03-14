<?php

namespace App\Http\Requests\Facility;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateFacilityRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('facilities', 'name')->ignore($this->route('id'))
            ],
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên cơ sở vật chất là bắt buộc',

            'name.string' => 'Tên cơ sở vật chất phải là chuỗi',

            'name.max' => 'Tên cơ sở vật chất tối đa 255 ký tự',

            'name.unique' => 'Tên cơ sở vật chất đã tồn tại',

            'is_active.boolean' => 'Trạng thái không hợp lệ',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',

            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',

        ];
    }
}
