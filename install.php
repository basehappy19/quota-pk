<?php
if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
    header('HTTP/1.0 404 Not Found');
    echo "404 Not Found";
    exit;
}

require_once 'config/db.php';

function setupDatabase($conn) {
    $sqlFile = 'quota.sql';
    if (!file_exists($sqlFile)) {
        echo "SQL file not found.";
        return;
    }

    $sql = file_get_contents($sqlFile);
    try {
        $conn->beginTransaction();
        $conn->exec($sql);
        $conn->commit();
        echo "Database setup completed successfully.";
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error setting up database: " . $e->getMessage();
    }
}

setupDatabase($conn);
?>
