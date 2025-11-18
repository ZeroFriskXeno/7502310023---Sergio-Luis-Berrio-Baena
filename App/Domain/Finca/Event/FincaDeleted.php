<?php
namespace App\Domain\Finca\Event;
use App\Domain\Finca\ValueObject\FincaId;
class FincaDeleted
{
    private FincaId $id;
    public function __construct(FincaId $id)
    {$this->id = $id;}
    public function id(): FincaId
    {return $this->id;}
}
