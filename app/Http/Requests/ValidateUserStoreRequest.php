<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//  php artisan make:request ValidateUserStoreRequest

class ValidateUserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {    
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required',

        ];
    }
}
