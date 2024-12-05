<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="icon" type="image/png" sizes="96x96" href="images/icon.png">
	<link rel="stylesheet" href="../assets/style.css">
  <link rel="stylesheet" href="../assets/page.css">

	<title>Ucheque</title>
	<!-- <script src="calendar.js" type="text/javascript"></script> -->


</head>
    <body>
        <div class="sidebar">
          <div class="logo"><img src="./assets/images/logoall-light.png" alt=""></div>
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
                <h2>user management</h2>
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
                <div class="add">
                  <div class="filter">
                    <select>
                      <option value="" disabled selected>Select Role</option>
                      <option value="option1">Staff</option>
                      <option value="option2">Faculty</option>
                      <option value="option3">HR</option>
                    </select>
                  </div>
                  <a href="import.php" class="btn-add">
                    <i class='bx bxs-file-import' ></i>
                    <span class="text">Import User</span>
                  </a>
                  <a href="add-user.php" class="btn-add">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Add User</span>
                  </a>
                  
                </div>
                          
             
                <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include '../config/config.php';

                            $limit = 10;

                            $totalResult = $conn->query("SELECT COUNT(*) AS total FROM employee");
                            $totalRows = $totalResult->fetch_assoc()['total'];
                            $totalPages = ceil($totalRows / $limit);

                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $page = max($page, 1); 
                           
                            $offset = ($page - 1) * $limit;

                           
                            $sql = "SELECT 
                              e.userId, e.employeeId, e.fistName, e.lastName, e.middleName, e.lastName, e.emailAddress,
                              e.phoneNumber, e.`status`, er.userId, er.role_id, r.`name`
                            FROM employee, employee_role, role
                            LIMIT $limit OFFSET $offset";
                            $result = $conn->query($sql);

                     
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $fullName = trim($row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']);
                                    echo '<tr data-role="' . $row['role_id'] . '">
                                            <td>' . $row['employeeId'] . '</td>
                                            <td>' . $fullName . '</td>
                                            <td>' . $row['emailAddress'] . '</td>
                                            <td>' . $row['phoneNumber'] . '</td>
                                            <td><span class="status">' . $row['name'] . '</span></td>
                                            <td><span class="status">' . $row['status'] . '</span></td>
                                            <td><a href="edit-act.php?employee_id=' . $row['employeeId'] . '" class="action">Edit</a>
                                                <a href="#1" class="action">Archive</a></td>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7">No users found.</td></tr>';
                            }
                            $conn->close();
                        ?>
                    </tbody>
                </table>

               <!-- Pagination Links -->
               <div class="pagination" id="pagination">
                <?php
                    if ($totalPages > 1) {
                        // First and Previous buttons
                        echo '<a href="?page=1" class="pagination-button">&laquo;</a>';
                        $prevPage = max(1, $page - 1);
                        echo '<a href="?page=' . $prevPage . '" class="pagination-button">&lsaquo;</a>';

                        // Numbered page links
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $activeClass = ($i == $page) ? 'active' : '';
                            echo '<a href="?page=' . $i . '" class="pagination-button ' . $activeClass . '">' . $i . '</a>';
                        }

                        // Next and Last buttons
                        $nextPage = min($totalPages, $page + 1);
                        echo '<a href="?page=' . $nextPage . '" class="pagination-button">&rsaquo;</a>';
                        echo '<a href="?page=' . $totalPages . '" class="pagination-button">&raquo;</a>';
                    }
                ?>
               </div>
            </div>


            </div>

            
    </body>
    <script src="/assets/pagination.js"></script>

    
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