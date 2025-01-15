<?php

namespace App\Repository;

use App\Database\Repository;

class EmployeeRepository extends Repository
{
    protected string $table = 'employees';
    
    public function findByUserId(int $userId): ?array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} WHERE user_id = ?",
            [$userId]
        );
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function createEmployee(array $data): int|false
    {
        return $this->insert([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'employee_type' => $data['employee_type']
        ]);
    }

    public function getDoctors(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} WHERE employee_type = 'DOCTOR'"
        );
        return $stmt->fetchAll();
    }
} 