<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
          'naslov' => 'required|min:3',
          'tijelo' => 'required|min:10'
        ];
    }

    public function messages(): array
    {
      return [
        'naslov.required' => 'Molimo unesite naslov.',
        'naslov.min' => 'Naslov mora imati barem 3 znakova.',
        'tijelo.required' => 'Molimo unesite tijelo posta.',
        'tijelo.min' => 'Tijelo mora imati barem 10 znakova.',
      ];
    }
}
