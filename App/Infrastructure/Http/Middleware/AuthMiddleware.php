<?php
namespace App\Infrastructure\Http\Middleware;
use App\Application\Auth\Service\JwtService;
use App\Domain\Users\Repository\UserRepository;
class AuthMiddleware
{
    public function __construct(
        private JwtService $jwt,
        private UserRepository $users
    ) {}
    public function handle(callable $next)
    {
        $headers = getallheaders();   
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Token no enviado']);
            return;
        }
        $authHeader = $headers['Authorization'];
        if (!str_starts_with($authHeader, 'Bearer ')) {
            http_response_code(401);
            echo json_encode(['error' => 'Formato de token inválido']);
            return;
        }
        $token = substr($authHeader, 7);
        $payload = $this->jwt->validate($token);
        if (!$payload) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o expirado']);
            return;
        }
        $user = $this->users->findById(
            new \App\Domain\Users\ValueObject\UserId($payload['user_id'])
        );
        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }
        $GLOBALS['auth_user'] = $user;
        return $next();
    }
}
