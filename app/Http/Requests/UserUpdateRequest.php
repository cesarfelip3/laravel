<?php

namespace App\Http\Requests;

use App\Forms\UserForm;

class UserUpdateRequest extends BaseRequest
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
        $id = request('id');

        return [
			'name' => 'required|min:3',
			'email' => "required|email|unique:users,id,{$id}"
        ];
    }


}
