<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

interface UpdateInvoiceApprovalStatus
{
    public function updateStatus(string $status, string $invoiceId): void;
}
