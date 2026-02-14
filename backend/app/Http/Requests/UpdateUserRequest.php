<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->route('user')->id;

        return [
            'name' => 'sometimes|string|max:100',
            'lastName' => 'sometimes|string|max:100',
            'email' => "sometimes|email|unique:users,email,$id",
            'dni' => "sometimes|string|unique:users,dni,$id",
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|string|in:user,admin'

        ];
    }
}
