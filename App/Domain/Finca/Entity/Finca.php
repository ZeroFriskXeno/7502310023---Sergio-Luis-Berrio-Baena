<?php
namespace App\Domain\Finca\Entity;

use App\Domain\Finca\ValueObject\FincaId;
use App\Domain\Finca\ValueObject\Nombre;
use App\Domain\Finca\ValueObject\NumHectareas;
use App\Domain\Finca\ValueObject\MetrosCuadrados;
use App\Domain\Finca\ValueObject\Propietario;
use App\Domain\Finca\ValueObject\Capataz;
use App\Domain\Finca\ValueObject\Pais;
use App\Domain\Finca\ValueObject\Departamento;
use App\Domain\Finca\ValueObject\Ciudad;
use App\Domain\Finca\ValueObject\ProduceLeche;
use App\Domain\Finca\ValueObject\ProduceCereales;
use App\Domain\Finca\ValueObject\ProduceFrutas;
use App\Domain\Finca\ValueObject\ProduceVerduras;

class Finca
{
    private FincaId $id;
    private Nombre $nombre;
    private NumHectareas $numHectareas;
    private MetrosCuadrados $metrosCuadrados;
    private Propietario $propietario;
    private Capataz $capataz;
    private Pais $pais;
    private Departamento $departamento;
    private Ciudad $ciudad;
    private ProduceLeche $produceLeche;
    private ProduceCereales $produceCereales;
    private ProduceFrutas $produceFrutas;
    private ProduceVerduras $produceVerduras;

    public function __construct
      (
        FincaId $id,
        Nombre $nombre,
        NumHectareas $numHectareas,
        MetrosCuadrados $metrosCuadrados,
        Propietario $propietario,
        Capataz $capataz,
        Pais $pais,
        Departamento $departamento,
        Ciudad $ciudad,
        ProduceLeche $produceLeche,
        ProduceCereales $produceCereales,
        ProduceFrutas $produceFrutas,
        ProduceVerduras $produceVerduras
      )
      {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->numHectareas = $numHectareas;
        $this->metrosCuadrados = $metrosCuadrados;
        $this->propietario = $propietario;
        $this->capataz = $capataz;
        $this->pais = $pais;
        $this->departamento = $departamento;
        $this->ciudad = $ciudad;
        $this->produceLeche = $produceLeche;
        $this->produceCereales = $produceCereales;
        $this->produceFrutas = $produceFrutas;
        $this->produceVerduras = $produceVerduras;
      }
    public function id(): FincaId { return $this->id; }
    public function nombre(): Nombre { return $this->nombre; }
}
