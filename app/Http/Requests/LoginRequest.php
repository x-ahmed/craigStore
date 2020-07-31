<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // VALIDATION RULES ADMIN LOGIN
            'email' => 'required|email',    // ADMIN EMAIL
            'password' => 'required',       // ADMIN PASSWORD
            
        ];

    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // VALIDATION MESSAGES OF ADMIN LOGIN
            'email.required' => 'Email is a mendatory input',           // ADMIN REQUIRED EMAIL MESSAGE
            'email.email' => 'Please enter a valid email',              // ADMIN INVALID EMAIL TYPE MESSAGE
            'password.required' => 'Password is a mandatory input',     // ADMIN REQUIRED PASSWORD MESSAGE
        ];

    }

}
