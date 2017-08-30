<?php

namespace App\Http\Requests;

use App\Forms\UserForm;

class UserCreateRequest extends BaseRequest
{
    public function form(): UserForm
    {
        return new UserForm($this);
    }

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
