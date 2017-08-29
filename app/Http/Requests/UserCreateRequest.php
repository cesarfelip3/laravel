<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    use UserRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required'
        ];
    }
}
