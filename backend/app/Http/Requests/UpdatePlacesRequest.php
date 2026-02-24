<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlacesRequest extends FormRequest
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
            'name' => "sometimes|string|max:255|unique:interesting_places,name",
            'gps' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del lugar es obligatorio.',
            'name.string' => 'El nombre del lugar debe ser una cadena de texto.',
            'name.max' => 'El nombre del lugar no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre del lugar ya está en uso.',
            'gps.required' => 'Las coordenadas GPS son obligatorias.',
            'gps.string' => 'Las coordenadas GPS deben ser una cadena de texto.',
            'gps.max' => 'Las coordenadas GPS no pueden tener más de 255 caracteres.',
        ];
    }
}
