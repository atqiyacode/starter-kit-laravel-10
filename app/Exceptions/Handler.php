<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;
use F9Web\ApiResponseHelpers;

class Handler extends ExceptionHandler
{
    use ApiResponseHelpers;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        if (app()->isProduction()) {
            $this->renderable(function (NotFoundHttpException $e, $request) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return $this->respondNotFound(trans('alert.error-not-found'));
                }
            });
            $this->renderable(function (UnauthorizedException $e, $request) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return $this->respondForbidden(trans('alert.error-forbidden'));
                }
            });

            $this->renderable(function (SpatieUnauthorizedException $e, $request) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return $this->respondForbidden(trans('alert.error-forbidden'));
                }
            });

            $this->renderable(function (AccessDeniedHttpException $e, $request) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return $this->respondForbidden(trans('alert.error-forbidden'));
                }
            });

            $this->renderable(function (TooManyRequestsHttpException $e, $request) {
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'title' => trans('alert.error-too-many-attempts-title'),
                        'message' => trans('alert.error-too-many-attempts-message'),
                    ], 429);
                }
            });
        }
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'title' => $exception->getMessage(),
            'message' => $exception->validator->getMessageBag()->first(),
            'errors' => $exception->errors(),
        ], $exception->status);
    }
}
