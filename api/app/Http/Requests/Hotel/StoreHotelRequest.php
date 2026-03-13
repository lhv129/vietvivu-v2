<?php

namespace App\Http\Requests\Hotel;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreHotelRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id' => 'required|exists:locations,id',

            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hotels', 'title')->withoutTrashed()
            ],

            'address' => 'required|string|max:255',

            'featured_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'media' => 'nullable|array',

            'media.*.path' => 'sometimes|string|max:255',

            'media.*.type' => 'sometimes|in:image,video,voice',

            'media.*.sort_order' => 'nullable|integer|min:0',

            'media.*.is_active' => 'nullable|boolean',

            'media.*.meta' => 'nullable|array',

            'is_active' => 'nullable|boolean',

            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [

            'location_id.required' => 'Vị trí khách sạn là bắt buộc.',
            'location_id.exists' => 'Vị trí khách sạn không tồn tại.',

            'title.required' => 'Tên khách sạn là bắt buộc.',
            'title.string' => 'Tên khách sạn phải là chuỗi.',
            'title.max' => 'Tên khách sạn tối đa 255 ký tự.',
            'title.unique' => 'Tên khách sạn đã tồn tại',

            'address.required' => 'Địa chỉ khách sạn là bắt buộc.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'address.max' => 'Địa chỉ tối đa 255 ký tự.',

            'featured_image.required' => 'Ảnh đại diện là bắt buộc.',
            'featured_image.image' => 'File tải lên phải là hình ảnh.',
            'featured_image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc webp.',
            'featured_image.max' => 'Ảnh không được lớn hơn 2MB.',

            'media.array' => 'Danh sách media không hợp lệ',
            'media.*.path.required' => 'Đường dẫn media là bắt buộc',
            'media.*.type.required' => 'Loại media là bắt buộc',
            'media.*.type.in' => 'Loại media chỉ được là image, video hoặc voice',
            'media.*.sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên',
            'media.*.is_active.boolean' => 'Trạng thái media không hợp lệ',
            'media.*.meta.array' => 'Meta phải là dạng object',

            'is_active.boolean' => 'Trạng thái không hợp lệ.',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp phải lớn hơn hoặc bằng 0.',
        ];
    }
}
