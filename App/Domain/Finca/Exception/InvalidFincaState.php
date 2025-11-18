<?php
namespace App\Domain\Finca\Exception;
class InvalidFincaState extends \DomainException
{
    public function __construct(string $message = "Estado inválido para la finca")
    {parent::__construct($message);}
}
