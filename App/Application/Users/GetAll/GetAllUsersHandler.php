<?php
namespace App\Application\Users\GetAll;
use App\Domain\Users\Repository\UserRepository;
class GetAllUsersHandler
{
    private UserRepository $repository;
    public function __construct(UserRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(): array
    {return $this->repository->findAll();}
}
