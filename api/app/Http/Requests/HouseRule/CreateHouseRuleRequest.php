<?php

namespace App\Http\Requests\HouseRule;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateHouseRuleRequest extends BaseRequest
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
                Rule::unique('house_rules', 'name')->withoutTrashed()
            ],
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên quy tắc nhà là bắt buộc',

            'name.string' => 'Tên quy tắc nhà phải là chuỗi',

            'name.max' => 'Tên quy tắc nhà tối đa 255 ký tự',

            'name.unique' => 'Tên quy tắc nhà đã tồn tại',

            'is_active.boolean' => 'Trạng thái không hợp lệ',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',

            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',

        ];
    }
}
