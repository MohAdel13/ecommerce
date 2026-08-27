<?php

namespace Modules\Ticket\Http\Requests;

use App\Exceptions\BusinessException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GetMessagesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'ticket_id' => ['nullable', 'integer', 'exists:tickets,id'],
            'page' => ['nullable', 'integer', 'min:1']
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
        throw new BusinessException(message: $validator->errors()->first(), code: 400, errors: [$validator->errors()->first()]);
    }
}