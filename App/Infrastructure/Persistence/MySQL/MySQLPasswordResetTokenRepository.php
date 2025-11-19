<?php
namespace App\Infrastructure\Persistence\MySQL;
use PDO;
use App\Application\Auth\Repository\PasswordResetTokenRepository;
class MySQLPasswordResetTokenRepository implements PasswordResetTokenRepository
{
    public function __construct(private PDO $pdo) {}
    public function createToken(string $email, string $token, int $expiresAt): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO password_resets (email, token, expires_at)
            VALUES (:email, :token, :expires)
        ");
        $stmt->execute([
            'email' => $email,
            'token' => $token,
            'expires' => $expiresAt
        ]);
    }
    public function validateToken(string $token): ?string
    {
        $stmt = $this->pdo->prepare("
            SELECT email FROM password_resets
            WHERE token = :token AND expires_at >= :now
        ");
        $stmt->execute([
            'token' => $token,
            'now' => time()
        ]);
        $result = $stmt->fetchColumn();
        return $result ?: null;
    }
    public function deleteToken(string $token): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM password_resets WHERE token = :t");
        $stmt->execute(['t' => $token]);
    }
}
