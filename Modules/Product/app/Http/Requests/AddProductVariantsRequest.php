<?php

namespace Modules\Product\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductVariantsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'variants' => ['required', 'array', 'min:1'],

            'variants.*' => ['required', 'array'],

            'variants.*.price' => ['required', 'numeric', 'min:0'],
            'variants.*.stock' => ['required', 'integer', 'min:0'],
            'variants.*.sku' => ['required', 'string', 'max:255', 'distinct', Rule::unique('product_variants', 'sku')],
            'variants.*.attributes' => ['required', 'array', 'min:1'],

            'variants.*.attributes.*' => ['required', 'array'],

            'variants.*.attributes.*.name_en' => ['required', 'string', 'max:255'],
            'variants.*.attributes.*.name_ar' => ['required', 'string', 'max:255'],
            'variants.*.attributes.*.value_en' => ['required', 'string', 'max:255'],
            'variants.*.attributes.*.value_ar' => ['required', 'string', 'max:255'],
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