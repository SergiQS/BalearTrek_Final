<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIslandsRequest extends FormRequest
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
        $id = $this->route('island')->id;

        return [
            //
            'name' => "required|string|max:255|unique:islands,name,$id",
        ];
    }

     public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la isla es obligatorio.',
            'name.string' => 'El nombre de la isla debe ser una cadena de texto.',
            'name.max' => 'El nombre de la isla no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre de la isla ya está en uso.',
        ];
    }
}
