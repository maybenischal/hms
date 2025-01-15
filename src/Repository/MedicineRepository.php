<?php

namespace App\Repository;

class MedicineRepository {
    private $db;
    private $table = 'medicines';

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }
} 