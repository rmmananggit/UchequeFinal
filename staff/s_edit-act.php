
<?php
include './includes/user_role.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="icon" type="image/png" sizes="96x96" href="images/icon.png">
	<link rel="stylesheet" href="/assets/style.css">

	<title>Ucheque</title>
	<!-- <script src="calendar.js" type="text/javascript"></script> -->
	
</head>
    <body>
        <div class="sidebar">
          <div class="logo"><img src="/images/logoall-light.png" alt=""></div>
          <ul class="menu">
            <li class="active">
                <a href="/staff/s_dash.html">
                  <i class="bx bxs-dashboard"></i>
                  <span>dashboard</span>
                </a>
            </li>
            <li>
                <a href="/staff/s_user.html">
                  <i class="bx bxs-group"></i>
                  <span>user management</span>
                </a>
            </li>
            <li>
                <a href="/staff/s_itl.html">
                  <i class='bx bxs-doughnut-chart'></i>
                  <span>employee ITL</span>
                </a>
            </li>
            <li>
                <a href="/staff/s_dtr.html">
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
                  <a href="/staff/s_profile.html">
                    <i class="bx bxs-user"></i>
                    My Profile
                  </a>
                  </li>
            
                  <li class="profile-dropdown-list-item">
                  <a href="/login.html">
                    <i class="bx bxs-log-out"></i>
                    Log out
                  </a>
                  </li>
                </ul>
                </div>
             </div>
              </div>
              <div class="tabular--wrapper">
               <div class="table-container">
                  <table>
                    <thead>
                      <tr>
                        <th>Email</th>
                        <th>status</th>
                        <th>action</th>
                      </tr>
                      <tbody>
                        <tr>
                          <td><input class="edt-email" type="text" placeholder="jcvanny@gmail.com"></td>
                          <!-- <td><span class="edit staff">Staff</span><span class="edit faculty">faculty</span><span class="edit hr">HR</span></td> -->
                          <td>
                            <select id="role">
                                <option value="" disabled selected>Status</option>
                                <option value="option1">Actvie</option>
                                <option value="option2">Inactive</option>
                            </select>
                            </td>
                          <td><a href="/staff/s_user.html" class="action">Save</a><a href="#1" class="action">Cancel</a></td>
                        </tr>
                       
                      </tbody>
                    </thead>
                  </table>
               </div>

                </div>
              </div>
            </div>
            
    </body>
    
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
    

 