<?php
require_once 'core/models.php';
require_once 'core/dbConfig.php';

if (isset($_GET['project_id'], $_GET['web_dev_id'])) {
    $project_id = $_GET['project_id'];
    $web_dev_id = $_GET['web_dev_id']; 

    // Validate and sanitize the inputs
    $project_id = intval($project_id);
    $web_dev_id = intval($web_dev_id); 

    $project = getProjectByID($pdo, $project_id); // Assuming this function exists in models.php

    if ($project) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Project</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <a href="viewprojects.php?web_dev_id=<?php echo $web_dev_id; ?>">View The Projects</a>
            <h1>Edit the project!</h1>

            <form action="core/handleForms.php" method="POST">
                <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                <input type="hidden" name="web_dev_id" value="<?php echo $web_dev_id; ?>">

                <p>
                    <label for="projectName">Project Name</label>
                    <input type="text" name="projectName" value="<?php echo $project['project_name']; ?>">
                </p>

                <p>
                    <label for="technologiesUsed">Technologies Used</label>
                    <input type="text" name="technologiesUsed" value="<?php echo $project['technologies_used']; ?>">
                </p>

                <input type="submit" name="editProjectBtn" value="Save Changes"> 
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Project not found.";
    }
} else {
    echo "Invalid request.";
}
?>