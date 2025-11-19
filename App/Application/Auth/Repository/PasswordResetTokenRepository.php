<?php
namespace App\Application\Auth\Repository;
interface PasswordResetTokenRepository
{
    public function createToken(string $email, string $token, int $expiresAt): void;
    public function validateToken(string $token): ?string;
    public function deleteToken(string $token): void;
}
