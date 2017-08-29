<?php

namespace App\Http\Requests;

trait UserRequest
{
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
