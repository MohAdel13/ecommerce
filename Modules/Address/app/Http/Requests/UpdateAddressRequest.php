<?php

namespace Modules\Address\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'address_name' => ['required', 'string', 'max:255'],
            'address_line' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'lat' => ['required', 'numeric', 'min:-90', 'max:90'],
            'lng' => ['required', 'numeric', 'min:-180', 'max:180'],
            'note' => ['nullable', 'string'],
            'is_default' => ['required', 'boolean'],
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