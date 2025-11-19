<?php
namespace App\Application\Finca\Update;
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
class UpdateFincaHandler
{
    private FincaRepository $repository;
    public function __construct(FincaRepository $repository)
    {$this->repository = $repository;}
    public function __invoke(UpdateFincaCommand $command)
    {
        $finca = $this->repository->findById(new FincaId($command->id()));
        if (!$finca) {throw new \Exception("Finca not found");}
        if ($command->nombre() !== null)
            $finca->changeNombre(new Nombre($command->nombre()));
        if ($command->ciudad() !== null)
            $finca->changeCiudad(new Ciudad($command->ciudad()));
        if ($command->departamento() !== null)
            $finca->changeDepartamento(new Departamento($command->departamento()));
        if ($command->pais() !== null)
            $finca->changePais(new Pais($command->pais()));
        if ($command->metrosCuadrados() !== null)
            $finca->changeMetrosCuadrados(new MetrosCuadrados($command->metrosCuadrados()));
        if ($command->numHectareas() !== null)
            $finca->changeNumHectareas(new NumHectareas($command->numHectareas()));
        if ($command->produceFrutas() !== null)
            $finca->changeProduceFrutas(new ProduceFrutas($command->produceFrutas()));
        if ($command->produceVerduras() !== null)
            $finca->changeProduceVerduras(new ProduceVerduras($command->produceVerduras()));
        if ($command->produceCereales() !== null)
            $finca->changeProduceCereales(new ProduceCereales($command->produceCereales()));
        if ($command->propietario() !== null)
            $finca->changePropietario(new Propietario($command->propietario()));
        if ($command->capataz() !== null)
            $finca->changeCapataz(new Capataz($command->capataz()));
        $this->repository->save($finca);
        return $finca;
    }
}
