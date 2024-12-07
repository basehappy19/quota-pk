<?php

function getSystemSettings($conn) {
    try {
        $sql = 'SELECT * FROM system_settings LIMIT 1'; 

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result;  
        } else {
            return null; 
        }
    } catch (Exception $e) {
        throw $e;
    }
}

