<?php
// Include database connection
include_once('../config/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $employeeId = $_POST['employeeId'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $roleId = $_POST['role'];  // The role_id selected by the user

    // Insert employee data into the `employee` table
    $query = "INSERT INTO employee (employeeId, firstName, middleName, lastName, emailAddress, phoneNumber) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $employeeId, $firstName, $middleName, $lastName, $emailAddress, $phoneNumber);

    if (!$stmt->execute()) {
        die('Error executing employee insertion query: ' . $stmt->error);
    }

    // Insert the role for the employee into the `roles_employee` table
    $rolesEmployeeQuery = "INSERT INTO roles_employee (employeeId, role_Id) VALUES (?, ?)";
    $rolesEmployeeStmt = $conn->prepare($rolesEmployeeQuery);
    $rolesEmployeeStmt->bind_param("ii", $employeeId, $roleId);

    if ($rolesEmployeeStmt->execute()) {
        header("Location: ../admin/user.php");
    } else {
        echo "Error assigning role to employee: " . $rolesEmployeeStmt->error;
    }
}

?>
