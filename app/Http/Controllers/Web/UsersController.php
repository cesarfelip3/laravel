<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware('needsRole:admin');
    }

    public function index()
    {
        return view('user.index');
    }
}
