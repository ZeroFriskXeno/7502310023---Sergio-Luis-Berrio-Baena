<?php
namespace App\Application\Finca\Create;
use App\Domain\Finca\Entity\Finca;
use App\Domain\Finca\Repository\FincaRepository;
use App\Domain\Finca\ValueObject\FincaId;
use App\Domain\Finca\ValueObject\Nombre;
use App\Domain\Finca\ValueObject\Ciudad;
use App\Domain\Finca\ValueObject\Departamento;
use App\Domain\Finca\ValueObject\Pais;
use App\Domain\Finca\ValueObject\MetrosCuadrados;
use App\Domain\Finca\ValueObject\NumHectareas;
use App\Domain\Finca\ValueObject\ProduceFrutas;
use App\Domain\Finca\ValueObject\ProduceVerduras;
use App\Domain\Finca\ValueObject\ProduceCereales;
use App\Domain\Finca\ValueObject\Propietario;
use App\Domain\Finca\ValueObject\Capataz;
class CreateFincaHandler
{
    private FincaRepository $repository;
    public function __construct(FincaRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(CreateFincaCommand $command): Finca
    {
        $finca = Finca::create(
            FincaId::random(),
            new Nombre($command->nombre()),
            new Ciudad($command->ciudad()),
            new Departamento($command->departamento()),
            new Pais($command->pais()),
            new MetrosCuadrados($command->metrosCuadrados()),
            new NumHectareas($command->numHectareas()),
            new ProduceFrutas($command->produceFrutas()),
            new ProduceVerduras($command->produceVerduras()),
            new ProduceCereales($command->produceCereales()),
            new Propietario($command->propietario()),
            new Capataz($command->capataz())
        );
        $this->repository->save($finca);
        return $finca;
    }
}
