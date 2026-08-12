<?php

namespace Modules\Product\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],

            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],

            'features' => ['nullable', 'array'],

            'features.*' => ['required', 'array'],

            'features.*.title_en' => ['string', 'required'],
            'features.*.title_ar' => ['string', 'required'],
            'features.*.description_en' => ['string', 'required'],
            'features.*.description_ar' => ['string', 'required'],

            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],

            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_variants', 'sku')
                    ->ignore($this->route('product')->defaultVariant->id),
            ],

            'delete_images_ids' => ['nullable', 'array'],
            'delete_images_ids.*' => ['integer'],

            'images' => ['nullable', 'array'],
            'images.*' => [
                'image',
                'mimes:png,jpg,jpeg,webp',
                'max:2048',
            ],
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