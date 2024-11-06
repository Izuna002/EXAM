<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['technician_id'])) { // Use 'technician_id' 
    $technician_id = $_GET['technician_id']; 

    // Validate and sanitize the input (example using intval)
    $technician_id = intval($technician_id); 

    $technician = getTechnicianByID($pdo, $technician_id); // Assuming this function exists in models.php

    if ($technician) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Technician</title>
            <link rel="stylesheet" href="styles.css"> 
        </head>
        <body>
            <h3>Edit Technician</h3>
            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="technician_id" value="<?php echo $technician['technician_id']; ?>"> 
                <p>
                    <label for="firstName">First Name</label>
                    <input type="text" name="firstName" value="<?php echo $technician['first_name']; ?>">
                </p>
                <p>
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lastName" value="<?php echo $technician['last_name']; ?>">
                </p>
                <p>
                    <label for="specialization">Specialization</label>
                    <input type="text" name="specialization" value="<?php echo $technician['specialization']; ?>">
                </p>
                <button type="submit" name="editTechnicianBtn">Save Changes</button> 
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Technician not found.";
    }
} else {
    echo "Invalid request.";
}
?>