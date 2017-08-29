<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
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

    public function name()
    {
        return $this->get('name');
    }

    public function email()
    {
        return $this->get('email');
    }

    public function role()
    {
        $role = (object) $this->get('role');

        return \Defender::findRoleById($role->id);
    }


}
