<?php
namespace App\Infrastructure\Persistence;
use PDO;
use App\Domain\Finca\Repository\FincaRepository;
use App\Domain\Finca\Entity\Finca;
use App\Domain\Finca\ValueObject\FincaId;
use App\Domain\Finca\ValueObject\Nombre;
use App\Domain\Finca\ValueObject\Ciudad;
use App\Domain\Finca\ValueObject\Departamento;
use App\Domain\Finca\ValueObject\Pais;
use App\Domain\Finca\ValueObject\MetrosCuadrados;
use App\Domain\Finca\ValueObject\NumHectareas;
use App\Domain\Finca\ValueObject\ProduceFrutas;
use App\Domain\Finca\ValueObject\ProduceVerduras;
use App\Domain\Finca\ValueObject\ProduceCereales;
use App\Domain\Finca\ValueObject\Propietario;
use App\Domain\Finca\ValueObject\Capataz;
class MySQLFincaRepository implements FincaRepository
{
    private PDO $connection;
    private string $table = 'fincas';
    public function __construct(PDO $connection)
    {$this->connection = $connection;}
    public function save(Finca $finca): void
    {
        $id = $finca->id()->value();
        $nombre = $finca->nombre()->value();
        $ciudad = $finca->ciudad()->value();
        $departamento = $finca->departamento()->value();
        $pais = $finca->pais()->value();
        $metros = $finca->metrosCuadrados()->value();
        $hectareas = $finca->numHectareas()->value();
        $frutas = $finca->produceFrutas()->value() ? 1 : 0;
        $verduras = $finca->produceVerduras()->value() ? 1 : 0;
        $cereales = $finca->produceCereales()->value() ? 1 : 0;
        $propietario = $finca->propietario()->value();
        $capataz = $finca->capataz()->value();
        $stmt = $this->connection->prepare("SELECT COUNT(*) as c FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $exists = (int)$stmt->fetch(PDO::FETCH_ASSOC)['c'] > 0;
        if ($exists) {
            $sql = "UPDATE {$this->table}
                    SET nombre = :nombre, ciudad = :ciudad, departamento = :departamento, pais = :pais,
                        metros_cuadrados = :metros, num_hectareas = :hectareas,
                        produce_frutas = :frutas, produce_verduras = :verduras, produce_cereales = :cereales,
                        propietario = :propietario, capataz = :capataz, updated_at = NOW()
                    WHERE id = :id";
            $params = [
                ':id' => $id,
                ':nombre' => $nombre,
                ':ciudad' => $ciudad,
                ':departamento' => $departamento,
                ':pais' => $pais,
                ':metros' => $metros,
                ':hectareas' => $hectareas,
                ':frutas' => $frutas,
                ':verduras' => $verduras,
                ':cereales' => $cereales,
                ':propietario' => $propietario,
                ':capataz' => $capataz,
            ];
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return;
        }
        $sql = "INSERT INTO {$this->table}
            (id, nombre, ciudad, departamento, pais, metros_cuadrados, num_hectareas,
             produce_frutas, produce_verduras, produce_cereales, propietario, capataz, created_at, updated_at)
            VALUES
            (:id, :nombre, :ciudad, :departamento, :pais, :metros, :hectareas,
             :frutas, :verduras, :cereales, :propietario, :capataz, NOW(), NOW())";
        $params = [
            ':id' => $id,
            ':nombre' => $nombre,
            ':ciudad' => $ciudad,
            ':departamento' => $departamento,
            ':pais' => $pais,
            ':metros' => $metros,
            ':hectareas' => $hectareas,
            ':frutas' => $frutas,
            ':verduras' => $verduras,
            ':cereales' => $cereales,
            ':propietario' => $propietario,
            ':capataz' => $capataz,
        ];
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
    }
    public function findById(FincaId $id): ?Finca
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id->value()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {return null;}
        return $this->hydrateFincaFromRow($row);
    }
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $fincas = [];
        foreach ($rows as $row) {
            $fincas[] = $this->hydrateFincaFromRow($row);
        }
        return $fincas;
    }
    public function delete(Finca $finca): void
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $finca->id()->value()]);
    }
    private function hydrateFincaFromRow(array $row): Finca
    {
        $id = new FincaId($row['id']);
        $nombre = new Nombre($row['nombre']);
        $ciudad = new Ciudad($row['ciudad']);
        $departamento = new Departamento($row['departamento']);
        $pais = new Pais($row['pais']);
        $metros = new MetrosCuadrados((float)$row['metros_cuadrados']);
        $hectareas = new NumHectareas((float)$row['num_hectareas']);
        $frutas = new ProduceFrutas((bool)$row['produce_frutas']);
        $verduras = new ProduceVerduras((bool)$row['produce_verduras']);
        $cereales = new ProduceCereales((bool)$row['produce_cereales']);
        $propietario = new Propietario($row['propietario']);
        $capataz = new Capataz($row['capataz']);
        return new Finca(
            $id,
            $nombre,
            $hectareas,
            $metros,
            $propietario,
            $capataz,
            $pais,
            $departamento,
            $ciudad,
            $frutas,
            $cereales,
            $verduras
        );
    }
}
