<?php
namespace App\Domain\Finca\ValueObject;
class MetrosCuadrados
{
    private int $value;
    public function __construct(int $value)
    {
        if ($value <= 0) {throw new \InvalidArgumentException("Los metros cuadrados deben ser mayores a 0");}
        $this->value = $value;
    }
    public function value(): int
    {return $this->value;}
}
