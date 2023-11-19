<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Command;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Application\Query\ReadModel\InvoicesFinder;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly final class RejectInvoice
{
    public function __construct(
        private InvoicesFinder $invoicesFinder,
        private ApprovalFacadeInterface $approvalFacade,
    ) {
    }

    public function execute(UuidInterface $id): void
    {
        $invoice = $this->invoicesFinder->find($id->toString());

        $this->approvalFacade->reject(
            new ApprovalDto(
                Uuid::fromString($invoice->id),
                StatusEnum::from($invoice->status),
                'invoice'
            )
        );
    }
}
