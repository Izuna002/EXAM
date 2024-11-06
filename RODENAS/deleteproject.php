<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (isset($_GET['project_id'], $_GET['web_dev_id'])) {
    $project_id = $_GET['project_id'];
    $web_dev_id = $_GET['web_dev_id'];

    // Validate and sanitize the inputs
    $project_id = intval($project_id);
    $web_dev_id = intval($web_dev_id);

    $project = getProjectByID($pdo, $project_id);

    if ($project) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Delete Project</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <h1>Are you sure you want to delete this repair?</h1>

            <div class="container"> 
                <h2>Project Name: <?php echo $project['project_name']; ?></h2>
                <h2>Technologies Used: <?php echo $project['technologies_used']; ?></h2>
                <h2>Project Owner: <?php echo $project['project_owner']; ?></h2> 
                <h2>Date Added: <?php echo $project['date_added']; ?></h2>

                <div class="deleteBtn"> 
                    <form action="core/handleForms.php" method="POST">
                        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                        <input type="hidden" name="web_dev_id" value="<?php echo $web_dev_id; ?>">
                        <input type="submit" name="deleteProjectBtn" value="Delete"> 
                    </form>
                </div>
            </div>
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