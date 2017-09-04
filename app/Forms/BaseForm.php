<?php

namespace App\Forms;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BaseForm
{
    protected $request;

    /**
     * BaseForm constructor.
     * @param FormRequest|\Tests\Fakers\FormRequest $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    protected function transformDate($value)
    {
        return Carbon::createFromFormat('m/d/Y', $value);
    }
}