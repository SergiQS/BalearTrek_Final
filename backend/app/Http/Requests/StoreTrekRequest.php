<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrekRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'regNumber' => 'required|string|max:255|unique:treks',
            'municipality_id' => 'required|exists:municipalities,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'regNumber.required' => 'El número de registro es obligatorio.',
            'regNumber.string' => 'El número de registro debe ser una cadena de texto.',
            'regNumber.max' => 'El número de registro no puede tener más de 255 caracteres.',
            'regNumber.unique' => 'El número de registro ya está en uso.',
            'municipality_id.required' => 'El municipio es obligatorio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',
        ];
    }
}
