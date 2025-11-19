<?php
namespace App\Infrastructure\Controllers;
use App\Application\User\Create\CreateUserHandler;
use App\Application\User\Create\CreateUserCommand;
use App\Application\User\Get\GetUserHandler;
use App\Application\User\GetAll\GetAllUsersHandler;
use App\Application\User\Update\UpdateUserHandler;
use App\Application\User\Delete\DeleteUserHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class UserController
{
    private CreateUserHandler $createHandler;
    private GetUserHandler $getHandler;
    private GetAllUsersHandler $getAllHandler;
    private UpdateUserHandler $updateHandler;
    private DeleteUserHandler $deleteHandler;
    public function __construct(
        CreateUserHandler $createHandler,
        GetUserHandler $getHandler,
        GetAllUsersHandler $getAllHandler,
        UpdateUserHandler $updateHandler,
        DeleteUserHandler $deleteHandler
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
        $user = ($this->createHandler)(
            new CreateUserCommand(
                $data['name'],
                $data['email'],
                $data['password']
            )
        );
        return new JsonResponse([
            'id' => $user->id()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
        ]);
    }
    public function get(string $id): JsonResponse
    {
        $user = ($this->getHandler)($id);
        return new JsonResponse([
            'id' => $user->id()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value()
        ]);
    }
    public function getAll(): JsonResponse
    {
        $users = ($this->getAllHandler)();
        return new JsonResponse(array_map(function ($user) {
            return [
                'id' => $user->id()->value(),
                'name' => $user->name()->value(),
                'email' => $user->email()->value()
            ];
        }, $users));
    }
    public function update(string $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = ($this->updateHandler)(
            new UpdateUserCommand(
                $id,
                $data['name'] ?? null,
                $data['email'] ?? null,
                $data['password'] ?? null
            )
        );
        return new JsonResponse([
            'id' => $user->id()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value()
        ]);
    }
    public function delete(string $id): JsonResponse
    {
        ($this->deleteHandler)($id);
        return new JsonResponse(['message' => 'Usuario eliminado']);
    }
}
