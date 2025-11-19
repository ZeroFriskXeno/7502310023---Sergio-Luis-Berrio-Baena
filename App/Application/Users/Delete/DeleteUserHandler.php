<?php
namespace App\Application\Users\Delete;
use App\Domain\Users\Repository\UserRepository;
use App\Domain\Users\ValueObject\UserId;
class DeleteUserHandler
{
    private UserRepository $repository;
    public function __construct(UserRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(string $id)
    {
        $user = $this->repository->findById(new UserId($id));
        if (!$user) {throw new \Exception("User not found");}
        $this->repository->delete($user);
    }
}
