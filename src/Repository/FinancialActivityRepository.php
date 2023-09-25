<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\FinancialActivity;
use App\Financial\Dto\FinancialActivityCreateDto;
use EonX\EasyRepository\Implementations\Doctrine\ORM\AbstractOptimizedDoctrineOrmRepository;

final class FinancialActivityRepository extends AbstractOptimizedDoctrineOrmRepository
{
    private const CREATE_FINANCIAL_ACTIVITY_SQL = <<<SQL
    BEGIN;
        SELECT 1 FROM team_member WHERE id = ':teamMemberId' FOR UPDATE;
        UPDATE team_member
        SET balance = balance + :value,
            sequential_number = sequential_number + 1,
            updated_at = NOW()
        WHERE id = ':teamMemberId';

        INSERT INTO financial_activity
        SELECT ':financialActivityId' AS id,
               ':teamId' AS team_id,
               ':teamMemberId' AS team_member_id,
               ':sessionId' AS session_id,
               ':gameId' AS game_id,
               ':title' AS title,
               ':type' AS type,
               currency,
               :value AS value,
               balance,
               sequential_number,
               ':createdById' AS created_by_id,
               ':createdById' AS updated_by_id,
               NOW() AS created_at,
               NOW() AS updated_at
        FROM team_member
        WHERE id = ':teamMemberId';
    COMMIT;
SQL;

    public function createSafelyFinancialActivity(FinancialActivityCreateDto $data): void
    {
        $conn = $this->getManager()->getConnection();
        $sql = self::CREATE_FINANCIAL_ACTIVITY_SQL;

        $mapping = [
            ':createdById' => $data->getCreatedById(),
            ':financialActivityId' => $data->getId(),
            ':gameId' => $data->getGameId(),
            ':teamId' => $data->getTeamId(),
            ':teamMemberId' => $data->getTeamMemberId(),
            ':title' => $data->getTitle(),
            ':type' => $data->getType(),
            ':sessionId' => $data->getSessionId(),
            ':value' => $data->getValue(),
        ];

        $sql = \str_replace(\array_keys($mapping), \array_values($mapping), $sql);

        try {
            $conn->executeStatement($sql);
        } catch (\Throwable $throwable) {
            $conn->executeStatement('ROLLBACK');

            throw $throwable;
        }
    }

    protected function getEntityClass(): string
    {
        return FinancialActivity::class;
    }
}