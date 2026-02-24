<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingsRequest extends FormRequest
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
            'dateIni' => 'required|date',
            'dateEnd' => 'required|date|after_or_equal:dateIni',
            'day' => 'required|date',
            'hour' => 'required',
            
        ];
    }

    public function messages(): array
    {
        return [
            'dateIni.required' => 'La fecha de inicio es obligatoria.',
            'dateIni.date' => 'La fecha de inicio debe ser una fecha válida.',
            'dateEnd.date' => 'La fecha de fin debe ser una fecha válida.',
            'dateEnd.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'day.required' => 'El día es obligatorio.',
            'day.date' => 'El día debe ser una fecha válida.',
            'hour.required' => 'La hora es obligatoria.',
        ];
    }
}
