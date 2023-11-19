<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Listener;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Application\Command\UpdateInvoiceStatus;

readonly final class UpdateInvoiceStatusOnApprovalEvent
{
    public function __construct(
        private UpdateInvoiceStatus $update
    ) {
    }

    public function approve(EntityApproved $event): void
    {
        if ($event->approvalDto->entity !== 'invoice') {
            return;
        }

        $this->update->execute($event->approvalDto->status->value, $event->approvalDto->id);

    }

    public function reject(EntityRejected $event): void
    {
        if ($event->approvalDto->entity !== 'invoice') {
            return;
        }

        $this->update->execute($event->approvalDto->status->value, $event->approvalDto->id);
    }

    public function subscribe($events): void
    {
        $events->listen(
            EntityApproved::class,
            'App\Modules\Invoices\Application\Listener\UpdateInvoiceStatus@approve'
        );

        $events->listen(
            EntityRejected::class,
            'App\Modules\Invoices\Application\Listener\UpdateInvoiceStatus@reject'
        );
    }
}
