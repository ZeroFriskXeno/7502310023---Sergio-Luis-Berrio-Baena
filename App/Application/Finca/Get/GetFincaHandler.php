<?php
namespace App\Application\Finca\Get;
use App\Domain\Finca\Repository\FincaRepository;
use App\Domain\Finca\ValueObject\FincaId;
class GetFincaHandler
{
    private FincaRepository $repository;
    public function __construct(FincaRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(string $id)
    {
        $finca = $this->repository->findById(new FincaId($id));
        if (!$finca) {throw new \Exception("Finca not found");}
        return $finca;
    }
}
