<?php
namespace App\Application\Auth\Service;
use App\Domain\Users\Repository\UserRepository;
use App\Application\Auth\Repository\PasswordResetTokenRepository;
class AuthService
{
    public function __construct(
        private UserRepository $users,
        private PasswordHasher $hasher,
        private JwtService $jwt,
        private PasswordResetTokenRepository $tokens
    ) {}
    public function login(string $email, string $password): ?string
    {
        $user = $this->users->findByEmail($email);
        if (!$user) return null;
        if (!$this->hasher->verify($password, $user->password())) {
            return null;
        }
        return $this->jwt->generate([
            'user_id' => $user->id()->value(),
            'email' => $user->email(),
        ]);
    }
    public function createResetToken(string $email): ?string
    {
        $user = $this->users->findByEmail($email);
        if (!$user) return null;
        $token = bin2hex(random_bytes(32));
        $expires = time() + 3600;
        $this->tokens->createToken($email, $token, $expires);
        return $token;
    }
    public function resetPassword(string $token, string $newPassword): bool
    {
        $email = $this->tokens->validateToken($token);
        if (!$email) return false;
        $user = $this->users->findByEmail($email);
        if (!$user) return false;
        $user->changePassword($this->hasher->hash($newPassword));
        $this->users->save($user);
        $this->tokens->deleteToken($token);
        return true;
    }
}
