<?php

namespace Modules\Category\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name_ar' => ['string', 'required', 'max:255', Rule::unique('categories', 'name_ar')],
            'name_en' => ['string', 'required', 'max:255', Rule::unique('categories', 'name_en')],
            'parent_id' => ['integer', 'nullable', Rule::exists('categories', 'id')],
            'image' => ['image', 'nullable', 'mimes:png,jpg,jpeg,webp', 'max:2048']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new BusinessException(message: __($validator->errors()->first()), code: 400, errors: [__($validator->errors()->first())]);
    }
}