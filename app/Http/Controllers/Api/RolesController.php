<?php

namespace App\Http\Controllers\Api;

use Defender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class RolesController extends Controller
{
    private $roles;

    function __construct()
    {
        $this->middleware('needsRole:admin');
        $this->roles = Defender::rolesList();
    }

    public function index()
    {
        $roles = null;

        if (Defender::is('slc'))
            $roles = $this->rolesForSlc();

        if (Defender::is('admin'))
            $roles = $this->rolesForAdmin();

        if (Defender::is('user'))
            $roles = $this->rolesForUser();

        return $this->parseResult($roles);
    }

    private function rolesForSlc()
    {
        return $this->roles->filter(function ($role) {
            return $role != 'slc';
        });
    }

    private function rolesForAdmin()
    {
        return $this->roles->filter(function ($role) {
            return $role != 'slc';
        });
    }

    private function rolesForUser()
    {
        return $this->roles->filter(function ($role) {
            return $role != 'slc'
                && $role != 'admin';
        });
    }

    private function parseResult(Collection $roles)
    {
        $list = [];
        foreach ($roles as $key => $role) {
            array_push($list, [
                'id' => $key,
                'name' => $role
            ]);
        }

        return $list;
    }
}
