<?php
namespace App\Application\Finca\Create;
class CreateFincaCommand
{
    private string $nombre;
    private string $ciudad;
    private string $departamento;
    private string $pais;
    private float $metrosCuadrados;
    private float $numHectareas;
    private bool $produceFrutas;
    private bool $produceVerduras;
    private bool $produceCereales;
    private string $propietario;
    private string $capataz;
    public function __construct(
        string $nombre,
        string $ciudad,
        string $departamento,
        string $pais,
        float $metrosCuadrados,
        float $numHectareas,
        bool $produceFrutas,
        bool $produceVerduras,
        bool $produceCereales,
        string $propietario,
        string $capataz
    ) {
        $this->nombre           = $nombre;
        $this->ciudad           = $ciudad;
        $this->departamento     = $departamento;
        $this->pais             = $pais;
        $this->metrosCuadrados  = $metrosCuadrados;
        $this->numHectareas     = $numHectareas;
        $this->produceFrutas    = $produceFrutas;
        $this->produceVerduras  = $produceVerduras;
        $this->produceCereales  = $produceCereales;
        $this->propietario      = $propietario;
        $this->capataz          = $capataz;
    }
    public function nombre(): string {return $this->nombre;}
    public function ciudad(): string {return $this->ciudad;}
    public function departamento(): string {return $this->departamento;}
    public function pais(): string {return $this->pais;}
    public function metrosCuadrados(): float {return $this->metrosCuadrados;}
    public function numHectareas(): float {return $this->numHectareas;}
    public function produceFrutas(): bool {return $this->produceFrutas;}
    public function produceVerduras(): bool {return $this->produceVerduras;}
    public function produceCereales(): bool {return $this->produceCereales;}
    public function propietario(): string {return $this->propietario;}
    public function capataz(): string {return $this->capataz;}
}
