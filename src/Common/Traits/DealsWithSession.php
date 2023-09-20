<?php
declare(strict_types=1);

namespace App\Common\Traits;

use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;

trait DealsWithSession
{
    protected function ensureSessionOpened(Session $session): void
    {
        if ($session->getStatus() !== SessionStatusEnum::OPENED) {
            throw new \RuntimeException('Session is not opened');
        }
    }
}