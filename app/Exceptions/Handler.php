<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Custom unauthenticated exception message
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => __('exceptions.AuthenticationException')], 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * Custom validation exception message
     *
     * @param ValidationException $e
     * @param Request $request
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($request->expectsJson()) {
            $e = new ValidationException($e->validator, (\response()->json([
                'message' => __('exceptions.ValidationException'),
                'errors' => $e->errors()
            ], $e->status)), $e->errorBag);
        }
        return parent::convertValidationExceptionToResponse($e, $request);
    }

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            switch (get_class($e)) {
                case AuthorizationException::class:
                    return response()->json(['message' => __('exceptions.AuthorizationException')], 403);
                case ThrottleRequestsException::class:
                    return response()->json(['message' => __('exceptions.ThrottleRequestsException')], 429);
                case ModelNotFoundException::class:
                    return response()->json(['message' => __('exceptions.ModelNotFoundException', [
                        'attribute' => __('validation.attributes.' . classToSlug($e->getModel()))
                    ])], 404);
                case NotFoundHttpException::class:
                    return response()->json(['message' => __('exceptions.NotFoundHttpException')], 404);
                case CustomException::class:
                    return response()->json(['message' => $e->getMessage()], $e->getCode());
                case QueryException::class:
                    $this->convertQueryExceptions($request, $e);
                    break;
                default:
                    return parent::render($request, $e);
            }
        }
        return parent::render($request, $e);
    }

    public function convertQueryExceptions($request, Throwable $e)
    {
        switch ($e->getCode()) {
            case "22P02":
                throw (new ModelNotFoundException())->setModel(@last(array_keys($request->route()->parameters)));
            default:
                break;
        }
    }
}
