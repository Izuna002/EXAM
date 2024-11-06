<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 

if (isset($_GET['technician_id'])) {
    $technician_id = $_GET['technician_id'];

    // Validate and sanitize the input
    $technician_id = intval($technician_id);

    $getTechnicianByID = getTechnicianByID($pdo, $technician_id);

    if ($getTechnicianByID) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Delete Technician</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <h1>Are you sure you want to delete this technician?</h1>
            <div class="container" style="border-style: solid; height: 300px;">
                <h2>First Name: <?php echo $getTechnicianByID['first_name']; ?></h2>
                <h2>Last Name: <?php echo $getTechnicianByID['last_name']; ?></h2>
                <h2>Specialization: <?php echo $getTechnicianByID['specialization']; ?></h2>

                <div class="deleteBtn" style="float: right; margin-right: 10px;">
                    <form action="core/handleForms.php" method="POST"> 
                        <input type="hidden" name="technician_id" value="<?php echo $technician_id; ?>"> 
                        <input type="submit" name="deleteTechnicianBtn" value="Delete">
                    </form>
                </div>
            </div>
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