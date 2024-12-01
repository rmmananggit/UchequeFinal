<?php
// Include your database connection
include_once('../config/config.php');

// Fetch roles from the roles table
$query = "SELECT role_id, role_name FROM roles";
$result = $conn->query($query);

// Check for any errors in the query
if (!$result) {
    die('Error fetching roles: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" sizes="96x96" href="images/icon.png">
    <link rel="stylesheet" href="../assets/style.css">

    <title>Add User - Ucheque</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><img src="../images/logoall-light.png" alt=""></div>
        <ul class="menu">
                <li>
                    <a href="index.php">
                      <i class="bx bxs-dashboard"></i>
                      <span>dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="user.php">
                      <i class="bx bxs-group"></i>
                      <span>user management</span>
                    </a>
                </li>
                <li>
                  <a href="itl.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span>employee ITL</span>
                  </a>
                </li>
                <li>
                  <a href="dtr.php">
                    <i class='bx bxs-time' ></i>
                    <span>employee DTR</span>
                  </a>
                </li>
                <li>
                  <a href="reports.php">
                      <i class='bx bxs-book-alt'></i>
                    <span>reports</span>
                  </a>
                </li>
                <li class="switch">
                    <a href="/loginas.php">
                      <i class='bx bx-code'></i>
                      <span>switch</span>
                    </a>
                </li>
            </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h2>Add User</h2>
            </div>
            <div class="user--info">
                <div class="profile-dropdown">
                    <div onclick="toggle()" class="profile-dropdown-btn">
                        <div class="profile-img"></div>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <ul class="profile-dropdown-list">
                        <li class="profile-dropdown-list-item">
                            <a href="profile.php">
                                <i class="bx bxs-user"></i> My Profile
                            </a>
                        </li>
                        <li class="profile-dropdown-list-item">
                            <a href="../logout.php">
                                <i class="bx bxs-log-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tabulars--wrapper">
            <div class="container mt-5">
            <form method="POST" action="../controller/add_user.php">
            <div class="card-body">
                <h4 class="card-title">Personal Information</h4>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="employeeId">Employee ID</label>
                        <input type="text" class="form-control" id="employeeId" name="employeeId" placeholder="Enter Employee ID" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middleName" placeholder="Enter Middle Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastName" placeholder="Enter Last Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="emailAddress" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="contact" name="phoneNumber" placeholder="Enter Contact Details">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="role">Account Role</label>
                        <select class="form-control" name="role" id="role" required>
                            <option value="" disabled selected>Select Role</option>

                            <?php
                            // Loop through the roles and create options for the select dropdown
                            while ($row = $result->fetch_assoc()) {
                                $roleId = $row['role_id'];
                                $roleName = $row['role_name'];
                                echo "<option value='$roleId'>$roleName</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='user.php';">Cancel</button>
                </div>
            </div>
        </form>

            </div>
        </div>
    </div>

    <script>
        let profileDropdownList = document.querySelector(".profile-dropdown-list");
        let btn = document.querySelector(".profile-dropdown-btn");

        const toggle = () => profileDropdownList.classList.toggle("active");

        window.addEventListener("click", function (e) {
            if (!btn.contains(e.target)) profileDropdownList.classList.remove("active");
        });
    </script>
</body>
</html>
