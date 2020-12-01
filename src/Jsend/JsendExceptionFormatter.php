<?php

namespace GuildMortgage\LaravelUtil\Jsend;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * @mixin \Illuminate\Foundation\Exceptions\Handler
 */
trait JsendExceptionFormatter
{
    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return jsend_fail(
            $exception->errors(),
            $exception->status
        );
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return jsend_fail($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof NotFoundHttpException) {
            return jsend_fail(empty($e->getMessage()) ? 'Route not found.' : $e->getMessage(), Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            return jsend_fail($e->getMessage(), $e->getStatusCode());
        }

        Log::error(get_class($e) . ': ' . $e->getMessage());

        return jsend_error('Something went wrong');
    }

}
