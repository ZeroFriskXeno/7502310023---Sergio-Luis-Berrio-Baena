<?php
namespace App\Infrastructure\Controllers;
use App\Application\Finca\Create\CreateFincaHandler;
use App\Application\Finca\Create\CreateFincaCommand;
use App\Application\Finca\Get\GetFincaHandler;
use App\Application\Finca\GetAll\GetAllFincasHandler;
use App\Application\Finca\Update\UpdateFincaHandler;
use App\Application\Finca\Update\UpdateFincaCommand;
use App\Application\Finca\Delete\DeleteFincaHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class FincaController
{
    private CreateFincaHandler $createHandler;
    private GetFincaHandler $getHandler;
    private GetAllFincasHandler $getAllHandler;
    private UpdateFincaHandler $updateHandler;
    private DeleteFincaHandler $deleteHandler;
    public function __construct(
        CreateFincaHandler $createHandler,
        GetFincaHandler $getHandler,
        GetAllFincasHandler $getAllHandler,
        UpdateFincaHandler $updateHandler,
        DeleteFincaHandler $deleteHandler
    ) {
        $this->createHandler = $createHandler;
        $this->getHandler = $getHandler;
        $this->getAllHandler = $getAllHandler;
        $this->updateHandler = $updateHandler;
        $this->deleteHandler = $deleteHandler;
    }
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $finca = ($this->createHandler)(
            new CreateFincaCommand(
                $data['nombre'],
                $data['ciudad'],
                $data['departamento'],
                $data['pais'],
                $data['metrosCuadrados'],
                $data['numHectareas'],
                $data['producesFrutas'],
                $data['producesVerduras'],
                $data['producesCereales'],
                $data['propietario'],
                $data['capataz']
            )
        );
        return new JsonResponse($finca->toPrimitives());
    }
    public function get(string $id): JsonResponse
    {
        $finca = ($this->getHandler)($id);
        return new JsonResponse($finca->toPrimitives());
    }
    public function getAll(): JsonResponse
    {
        $fincas = ($this->getAllHandler)();
        return new JsonResponse(array_map(fn($f) => $f->toPrimitives(), $fincas));
    }
    public function update(string $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $finca = ($this->updateHandler)(
            new UpdateFincaCommand(
                $id,
                $data['nombre'] ?? null,
                $data['ciudad'] ?? null,
                $data['departamento'] ?? null,
                $data['pais'] ?? null,
                $data['metrosCuadrados'] ?? null,
                $data['numHectareas'] ?? null,
                $data['producesFrutas'] ?? null,
                $data['producesVerduras'] ?? null,
                $data['producesCereales'] ?? null,
                $data['propietario'] ?? null,
                $data['capataz'] ?? null
            )
        );
        return new JsonResponse($finca->toPrimitives());
    }
    public function delete(string $id): JsonResponse
    {
        ($this->deleteHandler)($id);
        return new JsonResponse(['message' => 'Finca eliminada']);
    }
}
