<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Application\Query\ReadModel\InvoicesFinder;
use App\Modules\Invoices\Application\UpdateInvoiceApprovalStatus;
use App\Modules\Invoices\Infrastructure\Database\IlluminateUpdateInvoiceApprovalStatus;
use App\Modules\Invoices\Infrastructure\Database\IlluminateInvoicesFinder;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoicesFinder::class, IlluminateInvoicesFinder::class);
        $this->app->scoped(UpdateInvoiceApprovalStatus::class, UpdateInvoiceApprovalStatus::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoicesFinder::class,
            UpdateInvoiceApprovalStatus::class,
        ];
    }
}
