<?php
namespace App\Application\Users\Update;
use App\Domain\Users\Repository\UserRepository;
use App\Domain\Users\ValueObject\UserId;
use App\Domain\Users\ValueObject\UserName;
use App\Domain\Users\ValueObject\UserEmail;
use App\Domain\Users\ValueObject\UserPassword;
class UpdateUserHandler
{
    private UserRepository $repository;
    public function __construct(UserRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(UpdateUserCommand $command)
    {
        $user = $this->repository->findById(new UserId($command->id()));
        if (!$user) {throw new \Exception("User not found");}
        if ($command->name() !== null) {$user->changeName(new UserName($command->name()));}
        if ($command->email() !== null) {$user->changeEmail(new UserEmail($command->email()));}
        if ($command->password() !== null) {$user->changePassword(UserPassword::encode($command->password()));}
        $this->repository->save($user);
        return $user;
    }
}
