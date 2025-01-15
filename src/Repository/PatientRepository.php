<?php

namespace App\Repository;

use App\Database\Connection;

class PatientRepository {
    private $db;
    private $table = 'patients';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPatientDetails($id) {
        try {
            // Get basic patient info
            $sql = "SELECT p.*, u.email 
                   FROM {$this->table} p 
                   LEFT JOIN users u ON p.user_id = u.id 
                   WHERE p.id = ?";
            
            $stmt = $this->db->query($sql, [$id]);
            $patient = $stmt->fetch();

            if (!$patient) {
                return null;
            }

            // Get assigned doctors
            $doctorsSql = "SELECT e.id, e.name, da.created_at as assigned_date, 
                          CASE 
                            WHEN da.end_date IS NULL THEN 'Active'
                            ELSE 'Inactive'
                          END as status
                          FROM doctor_assignments da
                          JOIN employees e ON da.doctor_id = e.id
                          WHERE da.patient_id = ?
                          ORDER BY da.created_at DESC";
            
            $stmt = $this->db->query($doctorsSql, [$id]);
            $patient['doctors'] = $stmt->fetchAll();

            return $patient;
        } catch (\Exception $e) {
            error_log("Error getting patient details: " . $e->getMessage());
            return null;
        }
    }

    public function findAll() {
        $sql = "SELECT p.*, u.email 
                FROM {$this->table} p 
                LEFT JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function findById($id) {
        $sql = "SELECT * FROM patients WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function findByUserId($userId) {
        $stmt = $this->db->query(
            "SELECT p.*, u.email, u.user_name 
             FROM {$this->table} p 
             LEFT JOIN users u ON p.user_id = u.id 
             WHERE p.user_id = ?",
            [$userId]
        );
        return $stmt->fetch();
    }

    public function createPatient($data) {
        $stmt = $this->db->query(
            "INSERT INTO {$this->table} (
                user_id, name, date_of_birth, gender, phone, 
                address, blood_group, age, height, weight
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['user_id'],
                $data['name'],
                $data['date_of_birth'] ?? null,
                $data['gender'] ?? null,
                $data['phone'] ?? null,
                $data['address'] ?? null,
                $data['blood_group'] ?? null,
                $data['age'] ?? null,
                $data['height'] ?? null,
                $data['weight'] ?? null
            ]
        );
        return $this->db->lastInsertId();
    }

    public function getTotalPatients() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function getTodayPatients() {
        $stmt = $this->db->query(
            "SELECT COUNT(*) as total FROM {$this->table} 
             WHERE DATE(created_at) = CURDATE()"
        );
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    public function updatePatient($data) {
        try {
            $sql = "UPDATE patients SET 
                    name = ?, 
                    date_of_birth = ?, 
                    gender = ?, 
                    phone = ?, 
                    address = ? 
                    WHERE id = ?";
            
            return $this->db->query($sql, [
                $data['name'],
                $data['date_of_birth'],
                $data['gender'],
                $data['phone'],
                $data['address'],
                $data['id']
            ]);
        } catch (\Exception $e) {
            error_log("Error updating patient: " . $e->getMessage());
            return false;
        }
    }

    public function deletePatient(int $id): bool
    {
        try {
            // Start transaction
            $this->db->getPdo()->beginTransaction();

            // Delete related records in order
            $tables = [
                'medicine_schedule',  // Delete medicine schedules first
                'reports',           // Then delete reports
                'doctor_assignments', // Then delete doctor assignments
                'patients'           // Finally delete the patient record
            ];

            foreach ($tables as $table) {
                $sql = "DELETE FROM {$table} WHERE patient_id = ?";
                $this->db->query($sql, [$id]);
            }

            $this->db->getPdo()->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->getPdo()->rollBack();
            error_log("Failed to delete patient: " . $e->getMessage());
            return false;
        }
    }
} 