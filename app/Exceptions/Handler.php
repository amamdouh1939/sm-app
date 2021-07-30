<?php

namespace App\Exceptions;

use AElnemr\RestFullResponse\CoreJsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    use CoreJsonResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {

        if ($request->wantsJson()) {
            if ($exception instanceof AuthenticationException) {
                return $this->unauthorized();
            }

            if($exception instanceof AuthorizationException){
                return $this->forbidden();
            }

            if ($exception instanceof UserInvalidLoginException) {
                return $this->badRequest(null, __('message.invalid_user'));
            }

            if($exception instanceof ModelNotFoundException) {
                return $this->notFound(null, __('message.invalid_user'));
            }

            if ($exception instanceof ValidationException) {
                return $this->invalidRequest($exception->validator->getMessageBag()->toArray());
            }

            if ($exception instanceof UnauthorizedException) {
                return  $this->unauthorized(null, $exception->getMessage());
            }

        }
        return parent::render($request, $exception);
    }

}
