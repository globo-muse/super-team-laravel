<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validationRules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'department_id' => 'required|exists:departments,id',
            'role' => 'required|min:3|max:255',
            'image' => ['nullable', 'image'],
            'password' => 'required|min:6|max:15',
        ];

        if($this->method() == 'PUT') {
            unset($validationRules['password']);
        }

        return $validationRules;
    }
}
