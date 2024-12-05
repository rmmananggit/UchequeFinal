
<?php
// Include the database configuration file
include '../config/config.php';
session_start();

// Fetch roles from session
$user_roles = isset($_SESSION['roles']) ? $_SESSION['roles'] : [];
// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$staffCount = 0;
$facultyCount = 0;
$hrCount = 0;


$roles = [
    'Staff' => 'staff',
    'Faculty' => 'faculty',
    'HR' => 'HR'
];


foreach ($roles as $role => $roleName) {
    $stmt = $conn->prepare("
    SELECT COUNT(employeeId) AS count 
    FROM employee 
    WHERE role = ? ");

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('s', $roleName); 

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Assign counts based on role
        switch ($role) {
            case 'Staff':
                $staffCount = $row['count'];
                break;
            case 'Faculty':
                $facultyCount = $row['count'];
                break;
            case 'HR':
                $hrCount = $row['count'];
                break;
        }
    } else {
       
        echo "Error counting $role users: " . $stmt->error;
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="icon" type="image/png" sizes="96x96" href="images/logo-dark.png">
	<link rel="stylesheet" href="../assets/style.css">

	<title>Ucheque</title>
	<!-- <script src="calendar.js" type="text/javascript"></script> -->
	
</head>
    <body>
        <div class="sidebar">
            <div class="logo"><img src="../images/logoall-light.png" alt=""></div>
            <!-- <div class="logo"><img src="/images/logo-light.png" alt=""></div> -->
            <ul class="menu">
              <li class="active">
                  <a href="s_dash.php">
                    <i class="bx bxs-dashboard"></i>
                    <span>dashboard</span>
                  </a>
              </li>
              <li>
                  <a href="s_user.php">
                    <i class="bx bxs-group"></i>
                    <span>user management</span>
                  </a>
              </li>
              <li>
                  <a href="s_itl.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span>employee ITL</span>
                  </a>
              </li>
              <li>
                  <a href="s_dtr.php">
                    <i class='bx bxs-time' ></i>
                    <span>employee DTR</span>
                  </a>
              </li>
              <li>
                <a href="s_reports.php">
                    <i class='bx bxs-book-alt'></i>
                  <span>reports</span>
                </a>
            </li>
            <?php
            if(count($user_roles)>1)
            {
            ?>
              <li class="switch">
                  <a href="../loginas.php">
                    <i class='bx bx-code'></i>
                    <span>switch</span>
                  </a>
              </li>
              <?php
            }
              ?>
          </ul>
           
        </div>

        <div class="main--content">
            <div class="header--wrapper">
              <div class="header--title">
                <h2>Dashboard</h2>
              </div>
             <div class="user--info">
              <div class="profile-dropdown">
                <div onclick="toggle()" class="profile-dropdown-btn">
                  <div class="profile-img"></div>
                  <i class="bx bx-chevron-down"></i>
                </div>
            
                <ul class="profile-dropdown-list">
                  <li class="profile-dropdown-list-item">
                  <a href="s_profile.php">
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
            <div class="card--container">
                <h3 class="main--title"> Welcome back, Staff</h3>
            </div><br>

            <div class="card--container">
              <h3 class="main--title"> Accounts </h3>

              <ul class="box-info">
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo ($staffCount); ?></h3>
                        <p>Staff</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo ($facultyCount); ?></h3>
                        <p>Faculty</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo($hrCount); ?></h3>
                        <p>HR</p>
                    </span>
                </li>
            </ul>
            </div>
            <div class="table-data">
              <div class="order">
                <!-- insert calendar here -->
                 <div class="hero">
                  <div class="calendar">
                    <div class="left-calendar">
                      <p id="date">21</p>
                      <p id="day">Saturday</p>
      
                    </div>
                    <div class="right-calendar">
                      <p id="month">September</p>
                      <p id="year">2024</p>
      
                    </div>
                  </div>
                  <div class="academic-info">
                    <h1>Academic Information</h1>
                    <div class="semester-details">
                      <p><strong>Current Semester:</strong> <span id="currentSemester"></span></p>
                      <p><strong>School Year:</strong> <span id="schoolYear"></span></p>
                    </div>
                  </div>
                 </div>
              </div>

              <div class="todo">
                <div class="head">
                  <h3>Todos</h3>
                  <i class='bx bx-plus' ></i>
                  <i class='bx bx-filter' ></i>
                </div>
                <ul class="todo-list">
                  <li class="completed">
                    <p>Todo List</p>
                    <i class='bx bx-dots-vertical-rounded' ></i>
                  </li>
                  <li class="completed">
                    <p>Todo List</p>
                    <i class='bx bx-dots-vertical-rounded' ></i>
                  </li>
                  <li class="not-completed">
                    <p>Todo List</p>
                    <i class='bx bx-dots-vertical-rounded' ></i>
                  </li>
                  <li class="completed">
                    <p>Todo List</p>
                    <i class='bx bx-dots-vertical-rounded' ></i>
                  </li>
                  <li class="not-completed">
                    <p>Todo List</p>
                    <i class='bx bx-dots-vertical-rounded' ></i>
                  </li>
                </ul>
              </div>
            </div>
        </div>
        
       
    
    </body>
    <script src="../assets/acad.js" ></script>
    

    <script>
		
		let profileDropdownList = document.querySelector(".profile-dropdown-list");
		let btn = document.querySelector(".profile-dropdown-btn");

		let classList = profileDropdownList.classList;

		const toggle = () => classList.toggle("active");

		window.addEventListener("click", function (e) {
		if (!btn.contains(e.target)) classList.remove("active");
		});
	</script>

</html>    
    

 