<?php

namespace App\Repository;

use App\Database\Repository;

class ReportRepository extends Repository
{
    protected string $table = 'reports';
    
    public function getPatientReports(int $patientId): array
    {
        try {
            $sql = "SELECT r.*, e.name as created_by_name 
                    FROM {$this->table} r
                    LEFT JOIN employees e ON r.created_by = e.id
                    WHERE r.patient_id = ?
                    ORDER BY r.created_at DESC";
                    
            $stmt = $this->db->query($sql, [$patientId]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // If table doesn't exist, return empty array
            return [];
        }
    }

    public function createReport(array $data): int|false
    {
        return $this->insert([
            'patient_id' => $data['patient_id'],
            'report_type' => $data['report_type'],
            'report_content' => $data['report_content'],
            'created_by' => $data['created_by']
        ]);
    }

    public function deleteReport(int $id, int $patientId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ? AND patient_id = ?";
        return $this->db->query($sql, [$id, $patientId])->rowCount() > 0;
    }
} 