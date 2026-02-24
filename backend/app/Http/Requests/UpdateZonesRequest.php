<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZonesRequest extends FormRequest
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
        $id = $this->route('zone')->id;

        return [
            'name' => "sometimes|string|max:255|unique:zones,name,$id",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la zona es obligatorio.',
            'name.string' => 'El nombre de la zona debe ser una cadena de texto.',
            'name.max' => 'El nombre de la zona no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre de la zona ya está en uso.',
        ];
    }
}
