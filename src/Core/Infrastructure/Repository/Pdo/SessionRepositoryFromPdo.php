<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Infrastructure\Repository\Pdo;

use PDO;
use Tiagolopes\MyCashFlowApi\Core\Domain\Entity\Session;
use Tiagolopes\MyCashFlowApi\Core\Domain\Repository\SessionRepository;
use Tiagolopes\MyCashFlowApi\Core\Infrastructure\Database\Connection;

readonly class SessionRepositoryFromPdo implements SessionRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function store(Session $session): void
    {
        $sql = <<<SQL
            INSERT INTO sessions (id, token, user_id, expires_at)
            VALUES (:ID, :TOKEN, :USER_ID, :EXPIRES_AT)
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'ID', value: $session->id);
        $stmt->bindValue(param: 'TOKEN', value: $session->token);
        $stmt->bindValue(param: 'USER_ID', value: $session->userId, type: PDO::PARAM_INT);
        $stmt->bindValue(param: 'EXPIRES_AT', value: $session->expiresAt);
        $stmt->execute();
    }

    public function findByToken(string $token): ?Session
    {
        $sql = <<<SQL
            SELECT * FROM sessions WHERE token = :TOKEN
            LIMIT 1
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'TOKEN', value: $token);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! is_array($result) || empty($result)) {
            return null;
        }

        return Session::createFromDatabaseReturn($result);
    }

    public function delete(string $sessionId): void
    {
        $sql = <<<SQL
            DELETE FROM sessions WHERE id = :ID
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(param: 'ID', value: $sessionId);
        $stmt->execute();
    }
}
