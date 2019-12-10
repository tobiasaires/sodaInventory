<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FlattenException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    private function getExceptionClass($exception)
    {
        if (config('app.debug')) {
            return get_class($exception);
        }
        return null;
    }

    private function getExceptionMessageString($exception)
    {
        if (config('app.debug')) {
            return $exception->getMessage();
        }

        $messageStatusCode = Response::$statusTexts[$exception->getStatusCode()];

        return $messageStatusCode;
    }

    private function getTrace($exception)
    {
        if (config('app.debug')) {
            return 'file: ' . $exception->getFile() . ' line: ' . $exception->getLine();
        }
        return null;
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $jsonResponse = [
            'sucess' => false,
            'http_code' => 400,
            'exception' => $this->getExceptionClass($exception),
            'message' => $exception->getMessage(),
            'errors' => $exception->validator->getMessageBag(),
        ];

        return response()->json($jsonResponse, 400);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function prepareJsonResponse($request, Exception $exception)
    {

        $customException = FlattenException::create($exception);

        $jsonResponse = [
            'success' => false,
            'exception' => $this->getExceptionClass($exception),
            'http_code' => $customException->getStatusCode(),
            'message' => $this->getExceptionMessageString($exception),
        ];

        return response()->json($jsonResponse, $jsonResponse['http_code']);
    }

}
