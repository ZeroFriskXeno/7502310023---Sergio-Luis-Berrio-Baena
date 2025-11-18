<?php
namespace App\Domain\Finca\ValueObject;
use Ramsey\Uuid\Uuid;
class FincaId
{
    private string $value;
    public function __construct(string $value)
    {
        if (!Uuid::isValid($value)) {throw new \InvalidArgumentException("El ID de la finca no es un UUID válido");}
        $this->value = $value;
    }
    public static function generate(): self
    {return new self(Uuid::uuid4()->toString());}
    public function value(): string
    {return $this->value;}
    public function __toString(): string
    {return $this->value;}
}
