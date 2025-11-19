<?php
namespace App\Infrastructure\Controllers;
use App\Application\User\Login\LoginUserHandler;
use App\Application\User\Login\LoginUserCommand;
use App\Infrastructure\Security\JWTService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
class AuthController
{
    private LoginUserHandler $loginHandler;
    private JWTService $jwt;
    public function __construct(LoginUserHandler $loginHandler, JWTService $jwt)
    {
        $this->loginHandler = $loginHandler;
        $this->jwt = $jwt;
    }
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $user = ($this->loginHandler)(
            new LoginUserCommand($email, $password)
        );
        $token = $this->jwt->generateToken($user);
        return new JsonResponse([
            'token' => $token,
            'user' => [
                'id' => $user->id()->value(),
                'email' => $user->email()->value(),
                'name' => $user->name()->value()
            ]
        ]);
    }
}
