<?php
require_once '../core/dbConfig.php';
require_once '../core/models.php';

if (isset($_GET['technician_id'])) {
    $technician_id = intval($_GET['technician_id']);
    $technician = getTechnicianByID($pdo, $technician_id);

    if ($technician) {
        echo "<h2>Technician Details</h2>";
        echo "<p><strong>First Name:</strong> " . $technician['first_name'] . "</p>";
        echo "<p><strong>Last Name:</strong> " . $technician['last_name'] . "</p>";
        echo "<p><strong>Specialization:</strong> " . $technician['specialization'] . "</p>";
    } else {
        echo "Technician not found.";
    }
} else {
    echo "Invalid request.";
}
?>