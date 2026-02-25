<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateTreksRequest extends FormRequest
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
            'name' => "sometimes|string|max:255|unique:treks,name,",
            'regNumber' => "required|string|max:255|unique:treks,regNumber",
            'municipality_id' => 'required|exists:municipalities,id',
            
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del trek es obligatorio.',
            'name.string' => 'El nombre del trek debe ser una cadena de texto.',
            'name.max' => 'El nombre del trek no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre del trek ya está en uso.',
            'regNumber.required' => 'El número de registro del trek es obligatorio.',
            'regNumber.string' => 'El número de registro del trek debe ser una cadena de texto.',
            'regNumber.max' => 'El número de registro del trek no puede tener más de 255 caracteres.',
            'regNumber.unique' => 'El número de registro del trek ya está en uso.',
            'municipality_id.required' => 'El municipio es obligatorio.',
            'municipality_id.exists' => 'El municipio seleccionado no es válido.',
        ];
    }
}
