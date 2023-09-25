<?php

declare(strict_types=1);

namespace App\Financial;

use App\Financial\Dto\FinancialActivityCreateDto;
use App\Repository\FinancialActivityRepository;
use Symfony\Component\Uid\Factory\UuidFactory;

final class FinancialActivityCreator
{
    public function __construct(
        private readonly FinancialActivityRepository $financialActivityRepository,
        private readonly UuidFactory $uuidFactory,
    ) {
    }

    public function createFinancialActivity(FinancialActivityCreateDto $data): void
    {
        $data->setId((string)$this->uuidFactory->create());

        $this->financialActivityRepository->createSafelyFinancialActivity($data);
    }
}
