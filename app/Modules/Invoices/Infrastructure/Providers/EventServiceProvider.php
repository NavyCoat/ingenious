<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Application\Listener\ApproveInvoice;
use App\Modules\Invoices\Application\Listener\RejectInvoice;
use App\Modules\Invoices\Application\Listener\UpdateInvoiceStatusOnApprovalEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $subscribe = [
        UpdateInvoiceStatusOnApprovalEvent::class
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
