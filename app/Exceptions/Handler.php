<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return true;
    }

    protected function convertExceptionToResponse(Throwable $e): JsonResponse|ResponseAlias
    {
        return response()->json(
            [
                'error' => true,
                'message' => $e->getMessage()
            ],
            $e->getCode()
        );
    }

    #[ArrayShape(['error' => "bool", 'message' => "string"])]
    protected function convertExceptionToArray(Throwable $e): array
    {
        return [
            'error' => true,
            'message' => $e->getMessage()
        ];
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param ValidationException $e
     * @param Request $request
     * @return Response|JsonResponse|ResponseAlias|null
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    : Response|JsonResponse|ResponseAlias|null
    {
        if ($e->response) {
            return $e->response;
        }

        return response()->json([
            'errors' => $e->validator->errors()->getMessages()
        ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
