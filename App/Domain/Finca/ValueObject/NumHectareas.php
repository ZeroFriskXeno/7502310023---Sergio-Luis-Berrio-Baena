<?php
namespace App\Domain\Finca\ValueObject;
class NumHectareas
{
    private int $value;
    public function __construct(int $value)
    {
        if ($value <= 0) {throw new \InvalidArgumentException("El número de hectáreas debe ser mayor a 0");}
        $this->value = $value;
    }
    public function value(): int
    {return $this->value;}
}
