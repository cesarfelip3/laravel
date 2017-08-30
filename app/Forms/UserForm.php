<?php

namespace App\Forms;

class UserForm extends BaseForm
{
    public function name()
    {
        return $this->request->get('name');
    }

    public function email()
    {
        return $this->request->get('email');
    }

    public function role()
    {
        $role = (object)$this->request->get('role');

        return \Defender::findRoleById($role->id);
    }
}
