<?php 
session_start(); 


if (!isset($_SESSION['auth']) || !$_SESSION['auth']) {
    header("Location: ../login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" sizes="96x96" href="../images/icon.png">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/profile.css">
    <title>Ucheque</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><img src="../images/logoall-light.png" alt=""></div>
        <ul class="menu">
          <li><a href="dash.php"><i class="bx bxs-dashboard"></i><span>dashboard</span></a></li>
          <li><a href="user.php"><i class="bx bxs-group"></i><span>user management</span></a></li>
          <li><a href="itl.php"><i class='bx bxs-doughnut-chart'></i><span>employee ITL</span></a></li>
          <li><a href="dtr.php"><i class='bx bxs-time'></i><span>employee DTR</span></a></li>
          <li><a href="reports.php"><i class='bx bxs-book-alt'></i><span>reports</span></a></li>
          <li class="switch"><a href="/loginas.php"><i class='bx bx-code'></i><span>switch</span></a></li>
        </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h2>My profile</h2>
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
                                <i class="bx bxs-user"></i>
                                My Profile
                            </a>
                        </li>
                        <li class="profile-dropdown-list-item">
                            <a href="../logout.php">
                                <i class="bx bxs-log-out"></i>
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tabular--wrapper">
            <div class="profile-container">
                <div class="sidebar2">
                    <div class="profile-info">
                        <img src="../images/people.jpg" alt="Profile Picture" class="profile-pic">
                        <h2><?php echo $_SESSION['auth_user']['fullName']; ?></h2>
                        <p><?php echo implode(', ', $_SESSION['roles']); ?></p> <!-- Display user roles -->
                    </div>
                    <div class="sidebar-links">
                        <div class="info-section">
                            <p><strong>Email</strong><br><?php echo $_SESSION['auth_user']['email']; ?></p>
                        </div>
                        <div class="info-section">
                        <p><strong>Contact</strong><br><?php echo $_SESSION['auth_user']['phoneNumber']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="main-content">
                    <div class="edit-profile">
                        <a href="profile.php">Profile Details</a>
                        <a href="edit-profile.php">Edit Profile</a>
                        <a href="pass.php">Password & Security</a>
                    </div>
                    <form class="profile-form">
                        <div class="form-section"><br>
                            <label>First Name</label>
                            <input type="text" value="<?php echo $_SESSION['auth_user']['firstName']; ?>" >
                            <label>Middle Name</label>
                            <input type="text" value="<?php echo $_SESSION['auth_user']['middleName']; ?>">
                            <label>Last Name</label>
                            <input type="text" value="<?php echo $_SESSION['auth_user']['lastName']; ?>">
                        </div>
                    </form>

                </div>
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
