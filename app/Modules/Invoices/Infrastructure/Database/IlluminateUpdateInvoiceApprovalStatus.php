<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database;


use App\Modules\Invoices\Application\UpdateInvoiceApprovalStatus;
use Illuminate\Database\ConnectionInterface;

readonly class IlluminateUpdateInvoiceApprovalStatus implements UpdateInvoiceApprovalStatus
{
    public function __construct(
        private ConnectionInterface $db,
    ) {
    }

    public function updateStatus(string $status, string $invoiceId): void
    {
        try {
            $this->db->table('invoices')
                ->where('id', '=', $invoiceId)
                ->update(['status' => $status]);
        } catch (\Throwable $e) {
            //Handle some cases like no existing id, etc.
        }
    }
}
