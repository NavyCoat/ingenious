<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Command;


use App\Modules\Invoices\Application\UpdateInvoiceApprovalStatus;
use Ramsey\Uuid\UuidInterface;

readonly final class UpdateInvoiceStatus
{
    public function __construct(
        private UpdateInvoiceApprovalStatus $update
    ) {
    }

    public function execute(string $status, UuidInterface $id): void
    {
        $this->update->updateStatus($status, $id->toString());
    }
}
