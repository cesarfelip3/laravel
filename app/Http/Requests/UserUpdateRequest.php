<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
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
