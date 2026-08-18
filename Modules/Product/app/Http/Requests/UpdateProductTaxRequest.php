<?php

namespace Modules\Product\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Tax\Models\Tax;

class UpdateProductTaxRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tax_id' => ['required', 'integer', Rule::exists(Tax::class, 'id')->where('is_active', true)],
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