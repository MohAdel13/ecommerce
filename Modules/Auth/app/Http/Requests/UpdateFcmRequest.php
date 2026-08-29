<?php

namespace Modules\Auth\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFcmRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'fcm_token' => ['string', 'required']
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