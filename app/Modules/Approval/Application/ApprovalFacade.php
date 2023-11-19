<?php

declare(strict_types=1);

namespace App\Modules\Approval\Application;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use Illuminate\Contracts\Events\Dispatcher;
use LogicException;

final readonly class ApprovalFacade implements ApprovalFacadeInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function approve(ApprovalDto $entity): void
    {
        try {
            $this->validate($entity);
            $this->dispatcher->dispatch(new EntityApproved($entity));
        } catch (\Throwable $e) {
        }
    }

    public function reject(ApprovalDto $entity): void
    {
        try {
            $this->validate($entity);
            $this->dispatcher->dispatch(new EntityRejected($entity));
        } catch (\Throwable $e) {
        }
    }

    private function validate(ApprovalDto $dto): void
    {
        if (StatusEnum::DRAFT !== StatusEnum::tryFrom($dto->status->value)) {
            throw new LogicException('approval status is already assigned');
        }
    }
}
