<?php
namespace App\Infrastructure\Persistence;
use PDO;
use App\Domain\Users\Repository\UserRepository;
use App\Domain\Users\Entity\User;
use App\Domain\Users\ValueObject\UserId;
use App\Domain\Users\ValueObject\UserName;
use App\Domain\Users\ValueObject\UserEmail;
use App\Domain\Users\ValueObject\UserPassword;
class MySQLUserRepository implements UserRepository
{
    private PDO $connection;
    private string $table = 'users';
    public function __construct(PDO $connection)
    {$this->connection = $connection;}
    public function save(User $user): void
    {
        $id = $user->id()->value();
        $name = $user->name()->value();
        $email = $user->email()->value();
        $password = $user->password()->value();
        $stmt = $this->connection->prepare("SELECT COUNT(*) as c FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $exists = (int)$stmt->fetch(PDO::FETCH_ASSOC)['c'] > 0;
        if ($exists) {
            $sql = "UPDATE {$this->table}
                    SET name = :name, email = :email, password = :password, updated_at = NOW()
                    WHERE id = :id";
            $params = [
                ':id' => $id,
                ':name' => $name,
                ':email' => $email,
                ':password' => $password,
            ];
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return;
        }
        $sql = "INSERT INTO {$this->table} (id, name, email, password, created_at, updated_at)
                VALUES (:id, :name, :email, :password, NOW(), NOW())";
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
        ];

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
    }
    public function findById(UserId $id): ?User
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id->value()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {return null;}
        return $this->hydrateUserFromRow($row);
    }
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->hydrateUserFromRow($row);
        }
        return $users;
    }
    public function delete(User $user): void
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $user->id()->value()]);
    }
    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {return null;}
        return $this->hydrateUserFromRow($row);
    }
    private function hydrateUserFromRow(array $row): User
    {
        $id = new UserId($row['id']);
        $name = new UserName($row['name']);
        $email = new UserEmail($row['email']);
        $password = new UserPassword($row['password']);
        return new User($id, $name, $email, $password);
    }
}
