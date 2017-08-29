<?php

namespace App\Http\Controllers;

use Bugsnag;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function ok($data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        return Response::create($data, Response::HTTP_OK);
    }

    protected function notFound($data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        return Response::create($data, Response::HTTP_NOT_FOUND);
    }

    protected function badRequest($data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        return Response::create($data, Response::HTTP_BAD_REQUEST);
    }

    protected function forbidden($data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        return Response::create($data, Response::HTTP_FORBIDDEN);
    }

    protected function error(array $data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        return Response::create($data, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function fatal(Exception $e)
    {
        if (app()->environment() == 'production') {
            Bugsnag::notifyException($e);
        }

        $message = app()->environment() == 'local' ? $e->getMessage() : 'Unable to complete the operation. The support has already been notified about this incident!';
        return Response::create(["message" => $message], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
