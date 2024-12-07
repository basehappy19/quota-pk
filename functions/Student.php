<?php
function getStudentsWithPlans($conn, $selectedRoom = '')
{
    try {
        $sql = '
            SELECT 
                students.student_id,
                students.name,
                students.room,
                students.student_number,
                plans.name AS plan_name
            FROM students
            LEFT JOIN plans ON students.plan = plans.code
        ';

        if ($selectedRoom !== '') {
            $sql .= ' WHERE students.room = :room';
        }

        $stmt = $conn->prepare($sql);

        if ($selectedRoom !== '') {
            $stmt->bindParam(':room', $selectedRoom, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw $e;
    }
}
