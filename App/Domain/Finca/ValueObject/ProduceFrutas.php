<?php
namespace App\Domain\Finca\ValueObject;
class ProduceFrutas
{
    private bool $value;
    public function __construct(bool $value)
    {$this->value = $value;}
    public function value(): bool
    {return $this->value;}
}
