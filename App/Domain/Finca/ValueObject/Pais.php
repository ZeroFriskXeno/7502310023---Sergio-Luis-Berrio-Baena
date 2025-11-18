<?php
namespace App\Domain\Finca\ValueObject;
class Pais
{
    private string $value;
    public function __construct(string $value)
    {
        if (empty(trim($value))) {throw new \InvalidArgumentException("El país no puede estar vacío");}
        $this->value = $value;
    }
    public function value(): string
    {return $this->value;}
    public function __toString(): string
    {return $this->value;}
}
