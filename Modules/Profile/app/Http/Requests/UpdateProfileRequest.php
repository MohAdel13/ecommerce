<?php

namespace Modules\Profile\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255'],
            'email' => ['email', 'required', 'max:255', Rule::unique('users', 'email')->ignore(Auth::user()->id)],
            'phone' => ['string', 'required', 'min:10', 'max:20', Rule::unique('users', 'phone')->ignore(Auth::user()->id)],
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