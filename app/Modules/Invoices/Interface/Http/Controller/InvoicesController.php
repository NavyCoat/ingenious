<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Interface\Http\Controller;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Command\ApproveInvoice;
use App\Modules\Invoices\Application\Command\RejectInvoice;
use App\Modules\Invoices\Application\Query\InvoiceDetails;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InvoicesController extends Controller
{
    public function __construct(
        private readonly InvoiceDetails $invoiceDetails,
        private readonly ApproveInvoice $approveInvoice,
        private readonly RejectInvoice $rejectInvoice,
    ) {
    }

    public function show(string $id): Response
    {
        return new JsonResponse(
            [
                'invoices' => $this->invoiceDetails->query($id),
            ],
            Response::HTTP_OK
        );
    }

    public function approve(string $id): Response
    {
        $this->approveInvoice->execute(Uuid::fromString($id));

        return $this->responseLocationToApprovalService($id);
    }

    public function reject(string $id): Response
    {
        $this->rejectInvoice->execute(Uuid::fromString($id));

        return $this->responseLocationToApprovalService($id);
    }

    public function responseLocationToApprovalService(string $id): JsonResponse
    {
        return new JsonResponse(
            null,
            Response::HTTP_NO_CONTENT,
            [
                'Location' => 'url/to/approval/module/'.$id
            ]
        );
    }
}
