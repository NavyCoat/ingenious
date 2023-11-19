<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use App\Modules\Invoices\Domain\InvoiceWasAlreadyInApprovalProcess;
use App\Modules\Invoices\Infrastructure\Database\InvoiceNotFound;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     */
    public function register(): void
    {
        $this->renderable(function (InvoiceNotFound $e, Request $request) {
            return new JsonResponse([
                'status' => 'fail',
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        });
    }
}
