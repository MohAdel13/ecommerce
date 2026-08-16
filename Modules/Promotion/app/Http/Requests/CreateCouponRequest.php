<?php

namespace Modules\Promotion\Http\Requests;

use App\Enums\DiscountType;
use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => ['string', 'required', 'min:3', 'max:255', 'unique:coupons,code'],
            'discount_type' => ['required', Rule::enum(DiscountType::class)],
            'discount_value' => [
                'required',
                'numeric',
                'gt:0',
                Rule::when(
                    $this->discount_type === DiscountType::PERCENTAGE->value,
                    ['lte:100']
                ),
            ],
            'usage_limit' => ['integer', 'required', 'gte:1'],
            'usage_per_user' => ['integer', 'required', 'gte:1'],
            'starts_at' => ['required', 'date', 'after_or_equal:now'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
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