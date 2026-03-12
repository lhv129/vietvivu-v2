<?php

namespace App\Http\Requests\Location;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends BaseRequest
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
                Rule::unique('locations', 'name')->ignore($this->route('id'))
            ],

            'count' => 'sometimes|integer|min:0',

            'is_active' => 'sometimes|boolean',

            'thumbnail' => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048'

        ];
    }

    public function messages(): array
    {
        return [

            'name.string' => 'Tên địa điểm phải là chuỗi',

            'name.max' => 'Tên địa điểm tối đa 255 ký tự',

            'name.unique' => 'Tên địa điểm đã tồn tại',

            'count.integer' => 'Số lượng phải là số nguyên',

            'count.min' => 'Số lượng phải lớn hơn hoặc bằng 0',

            'is_active.boolean' => 'Trạng thái không hợp lệ',

            'thumbnail.image' => 'Thumbnail phải là hình ảnh',

            'thumbnail.mimes' => 'Thumbnail phải có định dạng jpg, jpeg, png hoặc webp',

            'thumbnail.max' => 'Thumbnail tối đa 2MB'

        ];
    }
}
