<?php
session_start();
include '../config/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $emailAddress = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    $login_query = "
        SELECT
            e.userId,
            e.firstName,
            e.middleName,
            e.lastName,
            e.password,
            e.emailAddress,
            e.userStatus,
            r.roleName
        FROM
            employee AS e
        JOIN
            employee_role AS er ON e.userId = er.employee_id
        JOIN
            role AS r ON er.role_id = r.roleId
        WHERE
            e.emailAddress = ?
    ";

    if ($stmt = $conn->prepare($login_query)) {
        $stmt->bind_param("s", $emailAddress);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $roles = [];
            $userData = null;

            while ($row = $result->fetch_assoc()) {
                if (!$userData) {
                    $userData = $row;
                }
                $roles[] = $row['roleName'];
            }

            if (password_verify($password, $userData['password'])) {
                $_SESSION['auth'] = true;
                $_SESSION['userstatus'] = $userData['userStatus'];
                $_SESSION['roles'] = $roles;
                $_SESSION['auth_user'] = [
                    'userId' => $userData['userId'],
                    'fullName' => $userData['firstName'] . ' ' . $userData['lastName'],
                    'email' => $userData['emailAddress']
                ];

                if ($userData['userStatus'] == 'Inactive') {
                    $_SESSION['status'] = "Your account is inactive!";
                    $_SESSION['status_code'] = "warning";
                    header("Location: ../index.php");
                    exit();
                } elseif ($userData['userStatus'] == 'Pending') {
                    $_SESSION['status'] = "Your account is still pending";
                    $_SESSION['status_code'] = "info";
                    header("Location: ../index.php");
                    exit();
                } elseif ($userData['userStatus'] == 'Active') {
                    $_SESSION['status'] = "Welcome " . $userData['firstName'] . "!";
                    $_SESSION['status_code'] = "success";
                    header("Location: ../loginas.php");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Invalid Password.";
                $_SESSION['status_code'] = "error";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['status'] = "No user found with this email.";
            $_SESSION['status_code'] = "error";
            header("Location: ../index.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = "Error in login query.";
        $_SESSION['status_code'] = "error";
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Invalid request method.";
    $_SESSION['status_code'] = "error";
    header("Location: ../index.php");
    exit();
}

$conn->close();
?>
