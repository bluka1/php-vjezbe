<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
          "email" => "email:rfc,dns"
        ];
    }

    public function messages(): array
    {
      return [
        "email.email" => "Molimo unesite ispravnu email adresu."
      ];
    }

    public function withValidator()
    {
      return;
    }
}
