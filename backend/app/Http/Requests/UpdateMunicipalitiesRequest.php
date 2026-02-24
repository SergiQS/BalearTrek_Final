<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMunicipalitiesRequest extends FormRequest
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
        $id = $this->route('municipality')->id;

        return [
            'name' => "sometimes|string|max:255|unique:municipalities,name,$id",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del municipio es obligatorio.',
            'name.string' => 'El nombre del municipio debe ser una cadena de texto.',
            'name.max' => 'El nombre del municipio no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre del municipio ya está en uso.',
        ];
    }
}
