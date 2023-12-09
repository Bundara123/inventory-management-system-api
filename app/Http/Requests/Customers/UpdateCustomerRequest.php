<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

use \Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
            'photo' => [
                'image',
                'file',
                'max:1024'
            ],
            'name' => [
                'required',
                'string',
                'max:50'
            ],
            'email' => [
                'required',
                'email',
                'max:50',
                // Rule::unique('customers', 'email')->ignore($this->customer);
            ],
            'phone' => [
                'required',
                'string',
                'max:25',
                // Rule::unique('customers', 'phone')->ignore($this->customer),
            ],
            'account_holder' => [
                'max:50'
            ],
            'account_number' => [
                'max:25'
            ],
            'bank_name' => [
                'max:25'
            ],
            'address' => [
                'required',
                'string',
                'max:100'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422));
    }
}
