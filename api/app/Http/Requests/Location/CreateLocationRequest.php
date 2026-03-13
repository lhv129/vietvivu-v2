<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateLocationRequest extends BaseRequest
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
                Rule::unique('locations', 'name')->withoutTrashed()
            ],
            'count' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Tên địa điểm là bắt buộc',

            'name.string' => 'Tên địa điểm phải là chuỗi',

            'name.max' => 'Tên địa điểm tối đa 255 ký tự',

            'name.unique' => 'Tên địa điểm đã tồn tại',

            'count.integer' => 'Số lượng phải là số nguyên',

            'count.min' => 'Số lượng phải lớn hơn hoặc bằng 0',

            'is_active.boolean' => 'Trạng thái không hợp lệ',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',

            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',

            'thumbnail.image' => 'Thumbnail phải là hình ảnh',

            'thumbnail.mimes' => 'Thumbnail phải có định dạng jpg, jpeg, png hoặc webp',

            'thumbnail.max' => 'Thumbnail tối đa 2MB'

        ];
    }
}
