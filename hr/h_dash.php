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
                    <a href="/hr/h_dash.php">
                      <i class="bx bxs-dashboard"></i>
                      <span>dashboard</span>
                    </a>
                </li>
                <li>
                  <a href="#">
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
                  <a href="h_profile.php">
                    <i class="bx bxs-user"></i>
                    My Profile
                  </a>
                  </li>
            
                  <li class="profile-dropdown-list-item">
                  <a href="/login.php">
                    <i class="bx bxs-log-out"></i>
                    Log out
                  </a>
                  </li>
                </ul>
                </div>
             </div>
              
            </div>
            <div class="card--container">
                <h3 class="main--title"> Welcome back, HR</h3>
            </div><br>

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
    <script src="/assets/acad.js" ></script>
    <script>
      const date = document.getElementById("date");
      const day = document.getElementById("day");
      const month = document.getElementById("month");
      const year = document.getElementById("year");
  
      const today = new Date();
  
      const weekDays = ["Sunday","Monday","Tuesday","Wednesday",
      "Thursday","Friday", "Saturday"];
      const allMonths = ["January","February","March","April",
      "May","June","July","August","September","October","November","December",];
  
      date.innerHTML = today.getDate();
      day.innerHTML = weekDays[today.getDay()] ;
      month.innerHTML = allMonths[today.getMonth()];
      year.innerHTML = today.getFullYear();
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
    

 