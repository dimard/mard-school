<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    /**
     * Get comprehensive class report with student grades from CBT and Assignments
     * 
     * @param int $classId The class ID
     * @return array Array of student reports with grades and rankings
     */
    public function getClassReport($classId)
    {
        // Get all students in the class
        $classMemberModel = new ClassMemberModel();
        $students = $classMemberModel->select('class_members.*, users.full_name, users.nis, users.email')
            ->join('users', 'users.id = class_members.student_id')
            ->where('class_id', $classId)
            ->findAll();

        if (empty($students)) {
            return [];
        }

        $report = [];

        foreach ($students as $student) {
            $studentId = $student['student_id'];

            // Get CBT exam scores for this class
            $cbtScores = $this->getCbtScoresForStudent($studentId, $classId);

            // Get assignment scores for this class
            $assignmentScores = $this->getAssignmentScoresForStudent($studentId, $classId);

            // Calculate averages
            $cbtAverage = !empty($cbtScores) ? array_sum($cbtScores) / count($cbtScores) : 0;
            $assignmentAverage = !empty($assignmentScores) ? array_sum($assignmentScores) / count($assignmentScores) : 0;

            // Calculate combined average (50% CBT + 50% Assignment)
            $combinedAverage = ($cbtAverage + $assignmentAverage) / 2;

            $report[] = [
                'student_id' => $studentId,
                'full_name' => $student['full_name'],
                'nis' => $student['nis'],
                'email' => $student['email'],
                'cbt_average' => round($cbtAverage, 2),
                'assignment_average' => round($assignmentAverage, 2),
                'combined_average' => round($combinedAverage, 2),
                'cbt_count' => count($cbtScores),
                'assignment_count' => count($assignmentScores)
            ];
        }

        // Sort by combined average (descending) for ranking
        usort($report, function ($a, $b) {
            return $b['combined_average'] <=> $a['combined_average'];
        });

        // Add ranking
        $rank = 1;
        foreach ($report as &$row) {
            $row['rank'] = $rank++;
        }

        return $report;
    }

    /**
     * Get CBT exam scores for a student in a specific class
     * 
     * @param int $studentId
     * @param int $classId
     * @return array Array of scores
     */
    private function getCbtScoresForStudent($studentId, $classId)
    {
        $db = \Config\Database::connect();

        // Get all CBT results for exams that belong to this class
        // We need to check if cbt_exams has class_id column
        $query = $db->query("
            SELECT cr.score 
            FROM cbt_results cr
            INNER JOIN cbt_exams ce ON ce.id = cr.exam_id
            WHERE cr.user_id = ? 
            AND cr.status = 'completed'
            AND cr.score IS NOT NULL
            AND ce.created_by IN (
                SELECT teacher_id FROM classes WHERE id = ?
            )
        ", [$studentId, $classId]);

        $results = $query->getResultArray();
        return array_column($results, 'score');
    }

    /**
     * Get assignment scores for a student in a specific class
     * 
     * @param int $studentId
     * @param int $classId
     * @return array Array of scores
     */
    private function getAssignmentScoresForStudent($studentId, $classId)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT asub.score
            FROM assignment_submissions asub
            INNER JOIN class_assignments ca ON ca.id = asub.assignment_id
            WHERE asub.user_id = ?
            AND ca.class_id = ?
            AND asub.score IS NOT NULL
        ", [$studentId, $classId]);

        $results = $query->getResultArray();
        return array_column($results, 'score');
    }

    /**
     * Get class statistics
     * 
     * @param array $report The class report array
     * @return array Statistics including highest, lowest, and average
     */
    public function getClassStatistics($report)
    {
        if (empty($report)) {
            return [
                'total_students' => 0,
                'highest_score' => 0,
                'lowest_score' => 0,
                'class_average' => 0,
                'cbt_average' => 0,
                'assignment_average' => 0
            ];
        }

        $combinedAverages = array_column($report, 'combined_average');
        $cbtAverages = array_column($report, 'cbt_average');
        $assignmentAverages = array_column($report, 'assignment_average');

        return [
            'total_students' => count($report),
            'highest_score' => max($combinedAverages),
            'lowest_score' => min($combinedAverages),
            'class_average' => round(array_sum($combinedAverages) / count($combinedAverages), 2),
            'cbt_average' => round(array_sum($cbtAverages) / count($cbtAverages), 2),
            'assignment_average' => round(array_sum($assignmentAverages) / count($assignmentAverages), 2)
        ];
    }
    /**
     * Get recent activity for a teacher (CBT results and Assignment submissions)
     * 
     * @param int $teacherId
     * @param int $limit
     * @return array
     */
    public function getTeacherRecentActivity($teacherId, $limit = 20)
    {
        $db = \Config\Database::connect();
        $results = [];

        // 1. Get recent CBT results
        // cbt_results (cr), cbt_exams (ce), users (u)
        $cbtSql = "
            SELECT 
                cr.end_time,
                u.full_name as student_name,
                ce.exam_name as exam_title,
                cr.score,
                'Ujian CBT' as type
            FROM cbt_results cr
            JOIN cbt_exams ce ON ce.id = cr.exam_id
            JOIN users u ON u.id = cr.user_id
            WHERE ce.created_by = ? 
            AND cr.status = 'completed'
            ORDER BY cr.end_time DESC
            LIMIT ?
        ";

        $cbtQuery = $db->query($cbtSql, [$teacherId, $limit]);
        foreach ($cbtQuery->getResultArray() as $row) {
            $results[] = $row;
        }

        // 2. Get recent Assignment submissions
        // assignment_submissions (asub), class_assignments (ca), users (u)
        $assignSql = "
            SELECT 
                asub.submitted_at as end_time,
                u.full_name as student_name,
                ca.title as exam_title,
                asub.score,
                'Tugas' as type
            FROM assignment_submissions asub
            JOIN class_assignments ca ON ca.id = asub.assignment_id
            JOIN users u ON u.id = asub.user_id
            WHERE ca.user_id = ?
            AND asub.submitted_at IS NOT NULL
            ORDER BY asub.submitted_at DESC
            LIMIT ?
        ";

        $assignQuery = $db->query($assignSql, [$teacherId, $limit]);
        foreach ($assignQuery->getResultArray() as $row) {
            $results[] = $row;
        }

        // Sort combined results by date descending
        usort($results, function ($a, $b) {
            return strtotime($b['end_time']) - strtotime($a['end_time']);
        });

        // Slice to limit
        return array_slice($results, 0, $limit);
    }
}
