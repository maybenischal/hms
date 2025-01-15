<?php

namespace App\Repository;

class DoctorAssignmentRepository {
    private $db;
    private $table = 'doctor_assignments';

    public function __construct($db) {
        $this->db = $db;
    }

    public function assignDoctor($data) {
        try {
            $sql = "INSERT INTO {$this->table} (patient_id, doctor_id, assigned_by) 
                    VALUES (?, ?, ?)";
            
            return $this->db->query($sql, [
                $data['patient_id'],
                $data['doctor_id'],
                $data['assigned_by']
            ]);
        } catch (\Exception $e) {
            error_log("Error assigning doctor: " . $e->getMessage());
            return false;
        }
    }

    public function getPatientAssignments($patientId) {
        $sql = "SELECT da.*, e.name as doctor_name 
                FROM {$this->table} da
                JOIN employees e ON da.doctor_id = e.id
                WHERE da.patient_id = ?
                ORDER BY da.created_at DESC";
        
        return $this->db->query($sql, [$patientId])->fetchAll();
    }

    public function deleteAssignment(int $id, int $patientId): bool
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ? AND patient_id = ?";
            return $this->db->query($sql, [$id, $patientId])->rowCount() > 0;
        } catch (\Exception $e) {
            error_log("Error deleting doctor assignment: " . $e->getMessage());
            return false;
        }
    }
} 