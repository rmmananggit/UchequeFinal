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
    <link rel="stylesheet" href="../assets/modal.css">
    <link rel="stylesheet" href="../assets/page.css">
    <title>Ucheque</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><img src="../images/logoall-light.png" alt=""></div>
        <ul class="menu">
            <li><a href="index.php"><i class="bx bxs-dashboard"></i><span>dashboard</span></a></li>
            <li><a href="user.php"><i class="bx bxs-group"></i><span>user management</span></a></li>
            <li><a href="itl.php"><i class='bx bxs-doughnut-chart'></i><span>employee ITL</span></a></li>
            <li><a href="dtr.php"><i class='bx bxs-time'></i><span>employee DTR</span></a></li>
            <li><a href="overload.php"><i class="bx bxs-user-check"></i><span>Overload Monitoring</span></a></li>
            <li><a href="reports.php"><i class='bx bxs-book-alt'></i><span>reports</span></a></li>
            <li class="switch"><a href="/loginas.php"><i class='bx bx-code'></i><span>switch</span></a></li>
        </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h2>Employee ITL</h2>
            </div>
            <div class="user--info">
                <div class="profile-dropdown">
                    <div onclick="toggle()" class="profile-dropdown-btn">
                        <div class="profile-img"></div>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <ul class="profile-dropdown-list">
                        <li class="profile-dropdown-list-item">
                            <a href="profile.php"><i class="bx bxs-user"></i>My Profile</a>
                        </li>
                        <li class="profile-dropdown-list-item">
                            <a href="/login.php"><i class="bx bxs-log-out"></i>Log out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tabular--wrapper">
            <div class="add">
                <div class="filter">
                    <select id="role">
                        <option value="" disabled selected>Select Designation</option>
                        <option value="option1">Designated</option>
                        <option value="option2">Non-Designated</option>
                    </select>
                </div>
                <div class="filter">
                    <select id="academic-year">
                        <option value="" disabled selected>Select Academic Year</option>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                        <option value="2026-2027">2026-2027</option>
                    </select>
                </div>
                <div class="filter">
                    <select id="academic-semester">
                        <option value="" disabled selected>Select Academic Semester</option>
                        <option value="1st">1st Semester</option>
                        <option value="2nd">2nd Semester</option>
                    </select>
                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>ITL File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../config/config.php';

                        $limit = 5;

                        $totalResult = $conn->query("SELECT COUNT(*) AS total FROM employee");
                        $totalRows = $totalResult->fetch_assoc()['total'];
                        $totalPages = ceil($totalRows / $limit);

                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $page = max($page, 1); 
                       
                        $offset = ($page - 1) * $limit;

                        $sql = "SELECT e.employeeId, e.firstName, e.middleName, e.lastName, u.filePath 
                            FROM employee e
                            LEFT JOIN uploaded_files u ON e.employeeId = u.employeeId
                            WHERE e.role = 'Faculty' 
                            LIMIT $limit OFFSET $offset";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $fullName = $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName'];
                                echo '<tr>
                                        <td>' . $row['employeeId'] . '</td>
                                        <td>' . $fullName . '</td>
                                        <td></td>
                                        <td>';

                                if (!empty($row['filePath'] )&& file_exists($row['filePath'])) {
                                    echo '<a href="../controller/view-file.php?employeeId=' . $row['employeeId'] . '" style="color: blue; text-decoration: underline;">itl.file</a>';
                                } else {
                                    echo 'No file';
                                }

                                echo '</td>
                                        <td>
                                            <button class="openModalBtn pointer-btn" data-id="' . $row['employeeId'] . '" data-name="' . $fullName . '">
                                                <img src="../images/edit-icon.png" alt="Edit" style="width: 20px;">
                                            </button>

                                            <a href="../controller/delete_file.php?employeeId=' . $row['employeeId'] . '" onclick="return confirm(\'Are you sure you want to delete this file?\')">
                                                <img src="../images/delete-icon.png" alt="Delete" style="width: 20px;">
                                            </a>

                                        </td>
                                    </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7">No faculty members found.</td></tr>';
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
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
            <!-- Modal -->
            <div id="fillUpModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close-btn">&times;</span>
                    <h2>Upload ITL file</h2>
                    <form id="fillUpForm" action="../controller/process_form.php" method="POST" enctype="multipart/form-data">
                        <label for="fullName">Name</label>
                        <input type="text" id="fullName" name="fullName" readonly>

                        <label for="id">ID</label>
                        <input type="text" id="id" name="id" readonly>

                        <label for="academicYear">Academic Year:</label>
                        <select id="academicYear" name="academicYear" >
                            <option value="">Select Academic Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($i = 0; $i < 5; $i++) { 
                                $startYear = $currentYear - $i;
                                $endYear = $startYear + 1;
                                echo "<option value='{$startYear}-{$endYear}'>{$startYear}-{$endYear}</option>";
                            }
                            ?>
                        </select>

                        <label for="academicSemester">Academic Semester:</label>
                        <select id="academicSemester" name="academicSemester" >
                            <option value="">Select Semester</option>
                            <option value="First Semester">First Semester</option>
                            <option value="Second Semester">Second Semester</option>
                            <option value="Summer Semester">Summer Semester</option>
                        </select>

                        <label for="uploadFile">Upload File:</label>
                        <input type="file" id="uploadFile" name="uploadFile" accept=".pdf,.docx,.txt" required>

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const modalBtns = document.querySelectorAll(".openModalBtn");
        const modal = document.getElementById("fillUpModal");
        const fullNameInput = document.getElementById("fullName");
        const idInput = document.getElementById("id");

        modalBtns.forEach((btn) => {
            btn.addEventListener("click", function () {
                const employeeId = this.getAttribute("data-id");
                const fullName = this.getAttribute("data-name");

                // Set the modal fields
                idInput.value = employeeId;
                fullNameInput.value = fullName;

                // Show the modal
                modal.style.display = "block";
            });
        });

        // Close button logic
        const closeBtn = document.querySelector(".close-btn");
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    });



    </script>

    <script>
        let profileDropdownList = document.querySelector(".profile-dropdown-list");
        let btn = document.querySelector(".profile-dropdown-btn");
        let classList = profileDropdownList.classList;

        const toggle = () => classList.toggle("active");

        window.addEventListener("click", function (e) {
            if (!btn.contains(e.target)) classList.remove("active");
        });
    </script>

    <script>
        function uploadFile(employeeId) {
        alert('Upload functionality for Employee ID: ' + employeeId);
      }

    function deleteRecord(employeeId) {
       
        if (confirm('Are you sure you want to delete this record?')) {
            alert('Deleting record for Employee ID: ' + employeeId);
         
        }
    }

    </script>
</body>
</html>
