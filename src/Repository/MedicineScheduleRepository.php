<?php

namespace App\Repository;

use App\Database\Repository;

class MedicineScheduleRepository extends Repository
{
    protected string $table = 'medicine_schedule';
    
    public function getPatientSchedules(int $patientId): array
    {
        try {
            $sql = "SELECT ms.*, m.name as medicine_name 
                    FROM {$this->table} ms
                    LEFT JOIN medicines m ON ms.medicine_id = m.id
                    WHERE ms.patient_id = ?
                    ORDER BY ms.start_date DESC";
                    
            $stmt = $this->db->query($sql, [$patientId]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // If table doesn't exist, return empty array
            return [];
        }
    }

    public function deleteSchedule(int $id, int $patientId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ? AND patient_id = ?";
        return $this->db->query($sql, [$id, $patientId])->rowCount() > 0;
    }
} 