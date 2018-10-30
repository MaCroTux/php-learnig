<?php

namespace Application\Storage;

class SqlLiteRepository
{
    private const FILE_DB = '/../app/database.sqli';

    public function __construct()
    {
        $this->conn = new \PDO("sqlite:".$_SERVER['CONTEXT_DOCUMENT_ROOT'].self::FILE_DB);
    }

    public function all(): array
    {
        $query = $this->conn->query(
            "SELECT *, 1 as priority, (SELECT count(*) FROM data_crawler d WHERE d.productId = p.id) as suggest FROM product p ORDER BY updateAt DESC"
        );
        $query->execute();

        return $query->fetchAll();
    }

    public function byId(string $id): array
    {
        $query = $this->conn->query("SELECT *, 1 as priority FROM product WHERE id = '$id'");
        $query->execute();

        return $query->fetchAll()[0];
    }

    public function insert(string $name): void
    {
        $id = uniqid();
        $updateAt = time();
        $query = $this->conn->query(
            "INSERT INTO product (id, name, updateAt) VALUES ('$id', '$name', '$updateAt')"
        );

        $query->execute();
    }

    public function remove(string $id): void
    {
        $query = $this->conn->query(
            "DELETE FROM product WHERE id = '$id'"
        );

        $query->execute();

        $query = $this->conn->query(
            "DELETE FROM data_crawler WHERE productId = '$id'"
        );

        $query->execute();
    }

    public function getSource(string $source, string $productId): array
    {
        $lastVersion = $this->lastVersion($productId) ?? 1;

        if(!$lastVersion) {
            $lastVersion = 1;
        }

        $query = $this->conn->query(
            "SELECT * FROM data_crawler WHERE source = '$source' AND productId = '$productId' AND version = $lastVersion ORDER BY updateAt DESC"
        );

        $query->execute();

        return $query->fetchAll();
    }

    private function lastVersion($productId){
        $query = $this->conn->query(
            "SELECT DISTINCT version FROM data_crawler WHERE productId = '$productId' ORDER BY version DESC"
        );

        if (!$query) {
            return 1;
        }

        $query->execute();

        return $query->fetchColumn();
    }

    public function save(array $data, string $productId): void
    {
        $insertValues = [];
        $date = time();

        $lastVersion = $this->lastVersion($productId)+1;

        foreach ($data as $item) {
            $id = uniqid();
            $insertValues[] = "('".$id."','".$productId."','pccomponentes','".$item['product']."','".$item['price']."','".$lastVersion."','".$date."') ";
        }

        $queryStr = "INSERT INTO data_crawler (id, productId, source, name, price, version, updateAt) VALUES ".implode(',', $insertValues);

        $query = $this->conn->query($queryStr);

        $query->execute();
    }
}
