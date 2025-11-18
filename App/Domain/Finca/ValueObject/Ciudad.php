<?php
namespace App\Domain\Finca\ValueObject;
class Ciudad
{
    private string $value;
    public function __construct(string $value)
    {
        if (empty(trim($value))) {throw new \InvalidArgumentException("La ciudad no puede estar vacía");}
        $this->value = $value;
    }
    public function value(): string
    {return $this->value;}
    public function __toString(): string
    {return $this->value;}
}
