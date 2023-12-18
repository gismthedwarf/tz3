<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'creds' => ['required', 'string', 'min:10'],
            'sum' => ['required', 'numeric'],
            'currency_id' => ['required', 'exists:currencies,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];

    }

    public function attributes()
    {
        return [
            'currency_id' => 'currency',
            'user_id' => 'user',
        ];
    }

}
