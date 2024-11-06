<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['repair_id'])) { 
    $repair_id = $_GET['repair_id'];  

    // Validate and sanitize the input
    $repair_id = intval($repair_id); 

    $repair = getRepairByID($pdo, $repair_id);

    if ($repair) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Repair</title>
            <link rel="stylesheet" href="style.css"> 
        </head>
        <body>
            <h3>Edit Repair</h3>
            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="repair_id" value="<?php echo $repair['repair_id']; ?>"> 
                <p>
                    <label for="device_type">Device Type</label>
                    <input type="text" name="device_type" value="<?php echo $repair['device_type']; ?>">
                </p>
                <p>
                    <label for="problem_description">Problem Description</label>
                    <input type="text" name="problem_description" value="<?php echo $repair['problem_description']; ?>">
                </p>
                <button type="submit" name="editRepairBtn">Save Changes</button> 
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Repair not found.";
    }
} else {
    echo "Invalid request.";
}
?>