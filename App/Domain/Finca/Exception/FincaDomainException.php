<?php
namespace App\Domain\Finca\Exception;
class FincaDomainException extends \DomainException
{
    public function __construct(string $message = "Error en el dominio de Finca")
    {parent::__construct($message);}
}
