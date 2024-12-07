<?php
function getPlans($conn) {
    try {
        $sql = '
            SELECT 
                plans.*, 
                COUNT(students.plan) AS num_students
            FROM 
                plans
            LEFT JOIN 
                students ON students.plan = plans.code
            GROUP BY 
                plans.code
            ORDER BY 
                plans.`order` ASC
        ';

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        throw $e;
    }
}

function PickPlan($conn, $studentId, $planCode) {
    try {
        $checkPlanSql = 'SELECT code FROM plans WHERE code = :planCode';
        $stmt = $conn->prepare($checkPlanSql);
        $stmt->bindParam(':planCode', $planCode, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new Exception('แผนการเรียนไม่ถูกต้องหรือไม่พบในระบบ');
        }

        $checkStudentSql = 'SELECT id FROM students WHERE id = :studentId';
        $stmt = $conn->prepare($checkStudentSql);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            $insertSql = 'INSERT INTO students (id, plan) VALUES (:studentId, :planCode)';
            $stmt = $conn->prepare($insertSql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':planCode', $planCode, PDO::PARAM_STR);
            $stmt->execute();

        } else {
            $updateSql = 'UPDATE students SET plan = :planCode WHERE id = :studentId';
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':planCode', $planCode, PDO::PARAM_STR);
            $stmt->execute();

        }
        return true;
    } catch (Exception $e) {
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
function getPlanStatistics($conn) {
    try {
        $sql = '
            SELECT 
                plans.name AS plan_name,       
                MAX(plans.color) AS plan_color,
                COUNT(students.plan) AS num_students
            FROM plans
            LEFT JOIN students ON students.plan = plans.code 
            GROUP BY plans.name 
        ';

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $planCounts = [];
        foreach ($result as $row) {
            $planCounts[] = [
                'plan_name' => $row['plan_name'],
                'num_students' => $row['num_students'],
                'plan_color' => $row['plan_color'],
            ];
        }

        return $planCounts; 
    } catch (Exception $e) {
        throw $e;
    }
}

