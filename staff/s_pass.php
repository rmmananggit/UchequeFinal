
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
    <link rel="stylesheet" href="/assets/profile.css">

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
                <h2>Edit Security password</h2>
              </div>
             <div class="user--info">
              <div class="profile-dropdown">
                <div onclick="toggle()" class="profile-dropdown-btn">
                  <div class="profile-img"></div>
                  <i class="bx bx-chevron-down"></i>
                </div>
            
                <ul class="profile-dropdown-list">
                  <li class="profile-dropdown-list-item">
                  <a href="/faculty/profile.html">
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
                    <div class="profile-container">
                        <div class="sidebar2">
                            <div class="profile-info">
                                <img src="/images/people.jpg" alt="Profile Picture" class="profile-pic">
                                <h2>Shakira Morales</h2>
                                <p>Faculty</p>
                            </div>
                           <div class="sidebar-links">
                                <div class="info-section">
                                    <p><strong>Associate professor 1</strong><br>Designation</p>
                                    <p><strong>Designated</strong><br>Designation</p>
                                </div>
                                <div class="info-section">
                                    <p><strong>Email</strong> <br>shak@gmail.com</p>
                                    <p><strong>Phone</strong><br> +639123456789</p>
                                </div>   <br> 
                                
                            </div> 
                        </div>
                        <div class="main-content">
                            <div class="edit-profile">
                              <a href="/staff/s_profile.html">Profile Details</a>
                              <a href="/staff/s_edit-profile.html">Edit Profile</a>
                              <a href="/staff/s_pass.html">Password & Security</a>
                          </div>  <br>
                            <form class="profile-form">
                                <div class="form-section">
                                    <label>Current password</label>
                                    <input type="text" placeholder="Enter current password">
                                    <label>New password</label>
                                    <input type="text" placeholder="Enter New Password">
                                    <label>Confirm Password</label>
                                    <input type="text" placeholder="Confirm Password">
                                    
                                </div>
                                <button type="submit" class="btn-pass">change Password</button>
                            </form>
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