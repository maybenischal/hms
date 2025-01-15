<?php

namespace App\Database;

abstract class Repository
{
    protected Connection $db;
    protected string $table;
    
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }
    
    public function find(int $id): ?array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} WHERE id = ?", 
            [$id]
        );
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    protected function insert(array $data): int|false
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        
        $this->db->query(
            "INSERT INTO {$this->table} ($columns) VALUES ($values)",
            array_values($data)
        );
        
        return $this->db->lastInsertId();
    }
} 