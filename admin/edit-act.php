<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="icon" type="image/png" sizes="96x96" href="images/logo-dark.png">
	<link rel="stylesheet" href="../assets/style.css">
	<title>Ucheque</title>

	
</head>
  <body>
    <div class="sidebar">
      <div class="logo"><img src="../images/logoall-light.png" alt=""></div>
      <!-- <div class="logo"><img src="/images/logo-light.png" alt=""></div> -->
      <ul class="menu">
        <li class="active">
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
          <a href="#">
            <i class='bx bxs-book-alt'></i>
            <span>reports</span>
          </a>
        </li>
        <li class="switch">
          <a href="#">
            <i class='bx bx-code'></i>
            <span>switch</span>
          </a>
        </li>
      </ul>
          
    </div><!--sidebar-->

    <div class="main--content">
      <div class="header--wrapper">
        <div class="header--title">
          <h2>edit user</h2>
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

          </div><!--profile-dropdown-->
        </div><!--user-info-->
      </div><!--header--wrapper-->

      <div class="tabular--wrapper">
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Email</th>
                <th>role</th>
                <th>status</th>
                <th>action</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td><input class="edt-email" type="text" placeholder="jcvanny@gmail.com"></td>
                <td><div class="role-group">
                  <button class="role-btn" id="staff-btn" onclick="toggleRole(this, 'staff')">Staff</button>
                  <button class="role-btn" id="faculty-btn" onclick="toggleRole(this, 'faculty')">Faculty</button>
                  <button class="role-btn" id="hr-btn" onclick="toggleRole(this, 'hr')">HR</button>
                </div></td>
                <td>
                  <select id="role">
                    <option value="" disabled selected>Status</option>
                    <option value="option1">Actvie</option>
                    <option value="option2">Inactive</option>
                  </select>
                </td>
                <td><a href="user.php" class="action">Save</a><a href="#1" class="action">Cancel</a></td>
              </tr>
              
            </tbody>
          </table>

        </div><!--table-container-->
      </div><!--tabular-wrapper-->
    </div><!--main-content-->

  </body>
  <script>
    function toggleRole(button, role) {
     let roleClass = role + '-selected';
     button.classList.toggle(roleClass);
    }
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

</html>    