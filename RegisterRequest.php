<?php

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => [
                'required',
                'string',
                'min:12', // Ensure the password has a minimum length of 12
                'max:20', // Limit the maximum password length to 20
                'regex:/[A-Z]/', // Must contain at least one uppercase letter
                'regex:/[a-z]/', // Must contain at least one lowercase letter
                'regex:/[0-9]/', // Must contain at least one numeric character
                'regex:/[@$!%*?&]/', // Must contain at least one special character
                function ($attribute, $value, $fail) {
                    // List of common passwords to avoid
                    $commonPasswords = ['123456', 'password', 'qwerty', '123456789', '12345678', '111111'];

                    if (in_array(strtolower($value), $commonPasswords)) {
                        $fail('The password is too common. Please choose a different password.');
                    }

                    if (str_contains(strtolower($value), strtolower($this->input('username') ?? ''))) {
                        $fail('The password contains the username.');
                    }

                    if (str_contains(strtolower($value), strtolower($this->input('email') ?? ''))) {
                        $fail('The password contains the email.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 12 characters long.',
            'password.max' => 'The password must not exceed 20 characters.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}
