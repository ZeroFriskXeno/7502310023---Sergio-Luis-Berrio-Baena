<?php
namespace App\Domain\Users\Repository;
use App\Domain\Users\Entity\User;
use App\Domain\Users\ValueObject\UserId;
interface UserRepository
{
    public function save(User $user): void;
    public function findById(UserId $id): ?User;
    public function findAll(): array;
    public function delete(User $user): void;
    public function findByEmail(string $email): ?User;
}
