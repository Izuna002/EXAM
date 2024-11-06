<?php

function insertNewUser($pdo, $username, $password) {
    try {
        $checkUserSql = "SELECT COUNT(*) FROM user_passwords WHERE username = ?";
        $checkUserStmt = $pdo->prepare($checkUserSql);
        $checkUserStmt->execute([$username]);
        $userExists = $checkUserStmt->fetchColumn();

        if ($userExists == 0) {
            $password = sha1($password); 

            $sql = "INSERT INTO user_passwords (username, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $executeQuery = $stmt->execute([$username, $password]); 

            if ($executeQuery) {
                $_SESSION['message'] = "User successfully inserted";
                return true;
            } else {
                $_SESSION['message'] = "An error occurred during insertion";
                return false; 
            }
        } else {
            $_SESSION['message'] = "User already exists";
            return false; 
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Database error: " . $e->getMessage();
        return false; 
    }
}

function loginUser($pdo, $username, $password) {
    try {
        $sql = "SELECT * FROM user_passwords WHERE username = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$username])) {
            $userInfoRow = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($userInfoRow); // Check the data fetched from the database

            if ($userInfoRow) {
                $usernameFromDB = $userInfoRow['username'];
                $hashedPasswordFromDB = $userInfoRow['password'];


                if (sha1($password) === $hashedPasswordFromDB) {
                    $_SESSION['username'] = $usernameFromDB;
                    $_SESSION['message'] = "Login successful!";
                    return true;
                } else {
                    $_SESSION['message'] = "Password invalid";
                    return false;
                }
            } else {
                $_SESSION['message'] = "User not registered";
                return false;
            }
        } else {
            $_SESSION['message'] = "Error during login";
            return false;
        }

    } catch (PDOException $e) {
        $_SESSION['message'] = "Database error: " . $e->getMessage();
        return false;
    }
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_passwords";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $user_id) {
    $sql = "SELECT * FROM user_passwords WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getAllTechnicians($pdo) {
    $sql = "SELECT * FROM Technicians";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getTechnicianByID($pdo, $technician_id) {
    $sql = "SELECT * FROM Technicians WHERE technician_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$technician_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getAllRepairs($pdo) {
    $sql = "SELECT * FROM Repairs";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getRepairByID($pdo, $repair_id) {
    $sql = "SELECT  
                R.repair_id AS repair_id,
                R.device_type AS device_type,
                R.problem_description AS problem_description,
                R.repair_date AS repair_date,
                CONCAT(T.first_name, ' ', T.last_name) AS technician_name,
                R.technician_id AS technician_id 
            FROM Repairs R
            JOIN Technicians T ON R.technician_id = T.technician_id
            WHERE R.repair_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$repair_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getRepairsByTechnicianID($pdo, $technician_id) {
    $sql = "SELECT  
                R.repair_id AS repair_id,
                R.device_type AS device_type,
                R.problem_description AS problem_description,
                R.repair_date AS repair_date,
                CONCAT(T.first_name, ' ', T.last_name) AS technician_name
            FROM Repairs R
            JOIN Technicians T ON R.technician_id = T.technician_id
            WHERE R.technician_id = ?
            GROUP BY R.repair_id"; 

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$technician_id]);

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function insertTechnician($pdo, $firstName, $lastName, $specialization) {
    $sql = "INSERT INTO Technicians (first_name, last_name, specialization) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$firstName, $lastName, $specialization]);
}

function insertRepair($pdo, $device_type, $problem_description, $technician_id, $repair_date) {  
    $sql = "INSERT INTO Repairs (device_type, problem_description, technician_id, repair_date) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$device_type, $problem_description, $technician_id, $repair_date]); 

    if ($executeQuery) {
        return true;
    }
}

function updateTechnician($pdo, $technician_id, $firstName, $lastName, $specialization) {
    $sql = "UPDATE Technicians  
            SET first_name = ?,  
                last_name = ?,  
                specialization = ?  
            WHERE technician_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$firstName, $lastName, $specialization, $technician_id]);
}

function updateRepair($pdo, $repair_id, $device_type, $problem_description) {
    $sql = "UPDATE Repairs  
            SET device_type = ?,  
                problem_description = ?
            WHERE repair_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$device_type, $problem_description, $repair_id]);
}

function deleteTechnician($pdo, $technician_id) {
    // First, delete related repairs
    $deleteRepairsSql = "DELETE FROM Repairs WHERE technician_id = ?";
    $deleteRepairsStmt = $pdo->prepare($deleteRepairsSql);
    $deleteRepairsStmt->execute([$technician_id]); 

    // Then, delete the technician
    $deleteTechnicianSql = "DELETE FROM Technicians WHERE technician_id = ?";
    $deleteTechnicianStmt = $pdo->prepare($deleteTechnicianSql);
    return $deleteTechnicianStmt->execute([$technician_id]); 
}


function getProjectByID($pdo, $project_id) {
    $sql = "SELECT 
                projects.project_id AS project_id,
                projects.project_name AS project_name,
                projects.technologies_used AS technologies_used,
                projects.date_added AS date_added,
                CONCAT(web_devs.first_name,' ', web_devs.last_name) AS project_owner
            FROM projects
            JOIN web_devs ON projects.web_dev_id = web_devs.web_dev_id
            WHERE projects.project_id = ?"; 

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$project_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function updateProject($pdo, $project_name, $technologies_used, $project_id) {
    $sql = "UPDATE projects 
            SET project_name = ?, technologies_used = ? 
            WHERE project_id = ?"; 

    $stmt = $pdo->prepare($sql);                                                        
    $executeQuery = $stmt->execute([$project_name, $technologies_used, $project_id]);

    if ($executeQuery) {
        return true;
    }                                                                   
}

function deleteProject($pdo, $project_id) {
    $sql = "DELETE FROM projects WHERE project_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$project_id]);

    if ($executeQuery) {
        return true;
    }
}

?>