<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['registerUserBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 

    if (!empty($username) && !empty($password)) {
        $insertQuery = insertNewUser($pdo, $username, $password); 

        if ($insertQuery) {
            header("Location: ../login.php"); 
            exit();
        } else {
            header("Location: ../register.php"); 
            exit();
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for registration!";
        header("Location: ../register.php"); 
        exit();
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];  

    if (!empty($username) && !empty($password)) {

        var_dump($username);
        var_dump($password);

        $loginQuery = loginUser($pdo, $username, $password); 

        if ($loginQuery) {
            header("Location: ../index.php"); 
            exit();
        } else {
            header("Location: ../login.php"); 
            exit();
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
        header("Location: ../login.php"); 
        exit();
    }
}

if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']);
    header('Location: ../login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['firstName'], $_POST['lastName'], $_POST['specialization'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $specialization = $_POST['specialization'];

        $query = insertTechnician($pdo, $firstName, $lastName, $specialization);

        if ($query) {
            $_SESSION['success_message'] = "Technician added successfully!";
            header("Location: ../index.php"); 
        } else {
            $_SESSION['error_message'] = "Failed to add technician.";
            header("Location: ../index.php"); 
        }
    } elseif (isset($_POST['formType']) && $_POST['formType'] === 'repair' &&
              isset($_POST['technician_id'], $_POST['device_type'], $_POST['problem_description'], $_POST['repair_date'])) {
        $technician_id = $_POST['technician_id'];
        $device_type = $_POST['device_type'];
        $problem_description = $_POST['problem_description'];
        $repair_date = $_POST['repair_date'];

        $query = insertRepair($pdo, $device_type, $problem_description, $technician_id, $repair_date);

        if ($query) {
            $_SESSION['success_message'] = "Repair added successfully!";
            header("Location: ../index.php"); 
        } else {
            $_SESSION['error_message'] = "Failed to add repair.";
            header("Location: ../index.php"); 
        }
    } elseif (isset($_POST['editTechnicianBtn'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $specialization = $_POST['specialization'];
        $technician_id = $_POST['technician_id'];

        $query = updateTechnician($pdo, $technician_id, $firstName, $lastName, $specialization);

        if ($query) {
            $_SESSION['success_message'] = "Technician updated successfully!";
            header("Location: ../pages/technicians/technicians.php"); 
        } else {
            $_SESSION['error_message'] = "Failed to update technician.";
            header("Location: ../index.php"); 
        }
    } elseif (isset($_POST['deleteTechnicianBtn'])) {
        $technician_id = $_POST['technician_id'];

        $query = deleteTechnician($pdo, $technician_id);

        if ($query) {
            $_SESSION['success_message'] = "Technician deleted successfully!"; 
            header("Location: ../index.php"); 
        } else {
            $_SESSION['error_message'] = "Failed to delete technician."; 
            header("Location: ../index.php"); 
        }
    } elseif (isset($_POST['insertNewRepairBtn'])) {
        $device_type = $_POST['device_type'];
        $problem_description = $_POST['problem_description'];
        $technician_id = $_POST['technician_id']; 
        $repair_date = $_POST['repair_date']; 

        $query = insertRepair($pdo, $device_type, $problem_description, $technician_id, $repair_date);

        if ($query) {
            $_SESSION['success_message'] = "Repair added successfully!";
            header("Location: ../index.php");
        } else {
            $_SESSION['error_message'] = "Failed to add repair."; 
            header("Location: ../index.php"); 
        }
    } elseif (isset($_POST['editProjectBtn'])) {
        $projectName = $_POST['projectName'];
        $technologiesUsed = $_POST['technologiesUsed'];
        $project_id = $_POST['project_id']; 
        $web_dev_id = $_POST['web_dev_id']; 

        $query = updateProject($pdo, $projectName, $technologiesUsed, $project_id);

        if ($query) {
            $_SESSION['success_message'] = "Project updated successfully!"; 
            header("Location: ../viewprojects.php?web_dev_id=" . $web_dev_id); 
        } else {
            $_SESSION['error_message'] = "Failed to update project."; 
            header("Location: ../viewprojects.php?web_dev_id=" . $web_dev_id); 
        }
    } elseif (isset($_POST['deleteProjectBtn'])) {
        $project_id = $_POST['project_id']; 
        $web_dev_id = $_POST['web_dev_id']; 

        $query = deleteProject($pdo, $project_id);

        if ($query) {
            $_SESSION['success_message'] = "Project deleted successfully!"; 
            header("Location: ../viewprojects.php?web_dev_id=" . $web_dev_id);
        } else {
            $_SESSION['error_message'] = "Failed to delete project.";
            header("Location: ../viewprojects.php?web_dev_id=" . $web_dev_id); 
        }
    } elseif (isset($_POST['editRepairBtn'])) { 
        $device_type = $_POST['device_type'];
        $problem_description = $_POST['problem_description'];
        $repair_id = $_POST['repair_id'];

        $query = updateRepair($pdo, $repair_id, $device_type, $problem_description);

        if ($query) {
            $_SESSION['success_message'] = "Repair updated successfully!";
            header("Location: ../index.php"); 
        } else {
            $_SESSION['error_message'] = "Failed to update repair.";
            header("Location: ../index.php"); 
        }
    }
}
?>