<?php

namespace App\Forms;

use Illuminate\Foundation\Http\FormRequest;

class BaseForm
{
    protected $request;

    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }
}