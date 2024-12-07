<?php


function Auth($conn, $studentId, $cid) {
    try {
        $sql = 'SELECT * FROM students WHERE student_id = :sid AND cid = :cid';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':sid', $studentId, PDO::PARAM_STR);
        $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$student){
            return null;
        }

        return $student;

    } catch (Exception $e) {
        throw $e;
    }
}

function getStudent($conn, $studentId) {
    try {
        $sql = '
            SELECT 
                students.*, 
                plans.code AS plan_code, 
                plans.name AS plan_name, 
                plans.min_GPAX AS plan_min_GPAX,
                plans.min_GPA_MAT AS plan_min_GPA_MAT,
                plans.min_GPA_SCI AS plan_min_GPA_SCI,
                plans.img_cover AS plan_image,
                plans.color AS plan_color
            FROM 
                students
            LEFT JOIN 
                plans ON students.plan = plans.code
            WHERE 
                students.id = :id
        ';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        throw $e;
    }
}
