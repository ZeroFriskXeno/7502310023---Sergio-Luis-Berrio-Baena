<?php
namespace App\Application\Finca\GetAll;
use App\Domain\Finca\Repository\FincaRepository;
class GetAllFincasHandler
{
    private FincaRepository $repository;
    public function __construct(FincaRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(): array
    {return $this->repository->findAll();}
}
