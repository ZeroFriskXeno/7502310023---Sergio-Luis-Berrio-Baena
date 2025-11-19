<?php
namespace App\Application\Finca\Update;
class UpdateFincaCommand
{
    private string $id;
    private ?string $nombre;
    private ?string $ciudad;
    private ?string $departamento;
    private ?string $pais;
    private ?float $metrosCuadrados;
    private ?float $numHectareas;
    private ?bool $produceFrutas;
    private ?bool $produceVerduras;
    private ?bool $produceCereales;
    private ?string $propietario;
    private ?string $capataz;
    public function __construct(
        string $id,
        ?string $nombre = null,
        ?string $ciudad = null,
        ?string $departamento = null,
        ?string $pais = null,
        ?float $metrosCuadrados = null,
        ?float $numHectareas = null,
        ?bool $produceFrutas = null,
        ?bool $produceVerduras = null,
        ?bool $produceCereales = null,
        ?string $propietario = null,
        ?string $capataz = null
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ciudad = $ciudad;
        $this->departamento = $departamento;
        $this->pais = $pais;
        $this->metrosCuadrados = $metrosCuadrados;
        $this->numHectareas = $numHectareas;
        $this->produceFrutas = $produceFrutas;
        $this->produceVerduras = $produceVerduras;
        $this->produceCereales = $produceCereales;
        $this->propietario = $propietario;
        $this->capataz = $capataz;
    }
    public function id(): string {return $this->id;}
    public function nombre(): ?string {return $this->nombre;}
    public function ciudad(): ?string {return $this->ciudad;}
    public function departamento(): ?string {return $this->departamento;}
    public function pais(): ?string {return $this->pais;}
    public function metrosCuadrados(): ?float {return $this->metrosCuadrados;}
    public function numHectareas(): ?float {return $this->numHectareas;}
    public function produceFrutas(): ?bool {return $this->produceFrutas;}
    public function produceVerduras(): ?bool {return $this->produceVerduras;}
    public function produceCereales(): ?bool {return $this->produceCereales;}
    public function propietario(): ?string {return $this->propietario;}
    public function capataz(): ?string {return $this->capataz;}
}
