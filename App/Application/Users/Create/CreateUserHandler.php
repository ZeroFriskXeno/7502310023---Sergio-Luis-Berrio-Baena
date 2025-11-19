<?php
namespace App\Application\Users\Create;
use App\Domain\Users\Entity\User;
use App\Domain\Users\Repository\UserRepository;
use App\Domain\Users\ValueObject\UserId;
use App\Domain\Users\ValueObject\UserName;
use App\Domain\Users\ValueObject\UserEmail;
use App\Domain\Users\ValueObject\UserPassword;
class CreateUserHandler
{
    private UserRepository $repository;
    public function __construct(UserRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(CreateUserCommand $command): User
    {
        $id       = UserId::random();
        $name     = new UserName($command->name());
        $email    = new UserEmail($command->email());
        $password = UserPassword::encode($command->password());
        $user = User::create(
            $id,
            $name,
            $email,
            $password
        );
        $this->repository->save($user);
        return $user;
    }
}
