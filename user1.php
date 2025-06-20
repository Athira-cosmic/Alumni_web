<?php
session_start();
include 'connect.php';

// Check if the user is logged in and their details are stored in the session
if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true && isset($_SESSION['reg_no'])) {
    // Fetch user details from the session
    $reg_no = $_SESSION['reg_no'];

    // Fetch user details from the database using $reg_no
   
	

    $sql = "SELECT * FROM `registration` WHERE reg_no='$reg_no'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 1) {
        $user_details = mysqli_fetch_assoc($result);
        // Now $user_details contains all the user details, you can access them as needed
        $name = $user_details['name'];
        $reg_no = $user_details['reg_no'];
        $department = $user_details['department'];
        $graduation_year = $user_details['year_of_passout'];
        $current_position = $user_details['designation'];
		$staff_advisor = $user_details['staff_advisor'];
        $email = $user_details['email'];
		$linkedin = $user_details['linkedin'];
    } else {
        // User not found in the database, handle this case accordingly
        echo "User not found in the database.";
    }
} else {
    // Redirect back to the sign-in page if the user is not logged in
    header('location:signin.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ph_no = $_POST['ph_no'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $company = $_POST['company'];
    $designation = $_POST['designation'];
    $email = $_POST['email'];

    $updateSql = "UPDATE registration 
                  SET ph_no = ?, address_line1 = ?, address_line2 = ?, city = ?, state = ?, country = ?, company = ?, designation = ?, email = ?
                  WHERE reg_no = ?";
    $stmt = mysqli_prepare($con, $updateSql);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $ph_no, $address_line1, $address_line2, $city, $state, $country, $company, $designation, $email, $reg_no);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile updated successfully'); window.location.href=window.location.href;</script>";
    } else {
        echo "<script>alert('Failed to update profile');</script>";
    }

    mysqli_stmt_close($stmt);
}


?>
<!doctype html>
<html lang="en">

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/case-study.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:42 GMT -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Welcome</title>
	
	<link rel="icon" href="assets/images/fav.png" type="image/gif" sizes="20x20">

	<!-- Jquery Ui CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css"/>
	<!-- Box Icon CSS -->
	<link rel="stylesheet" href="assets/css/boxicons.min.css">
	<!-- Bootstrap Icon CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-icons.css">
	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<!-- Magnific Popup CSS -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- Odometer CSS -->
	<link rel="stylesheet" href="assets/css/odometer.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Animate CSS -->
	<link rel="stylesheet" href="assets/css/animate.css">

	
	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="assets/css/responsive.css">
	<style>
        /* Some basic CSS for styling */
		.modal-bg {
            display: none; 
            position: fixed; 
            z-index: 999; 
            left: 0; top: 0;
            width: 100vw; height: 100vh;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6); /* translucent background */
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            max-height: 90vh;
            overflow-y: auto;
        }
        @keyframes fadeIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
            }
        .modal-content .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
        .close {
            float: right;
            font-size: 26px;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            }
        .close:hover {
            color: #e74c3c;
            }
        label { font-weight: bold; }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
        }
        /* Form elements */
        .modal-content form label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        .modal-content form input[type="text"],
        .modal-content form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .modal-content form input[type="text"]:focus,
        .modal-content form input[type="email"]:focus {
            border-color: #3498db;
            outline: none;
        }

/* Submit button */
        .modal-content form input[type="submit"] {
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-content form input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .modal-bg {
    transition: opacity 0.3s ease;
    opacity: 1;
}
        #editProfileBtn {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        #notifications-container {
			background-color: 1px solid #19075f;
			border-radius: 15px;
            display: flex;
			padding: 25px;
            flex-wrap: wrap;
			box-shadow: 0 2px 30px rgba(9, 2, 82, 0.637);
        }
        .notification {
            border: 1px solid #ccc;
            padding: 10px;
            margin-right: 20px;
            margin-bottom: 20px;
            flex: 1 0 calc(33.33% - 20px); 
            box-sizing: border-box;
        }
        .notification:last-child {
            margin-right: 0;
        }
        .notification h3 {
            margin-top: 0;
        }
        .notification p {
            margin-bottom: 0;
        }
        .notification img {
            width: auto;
            height: 180px;
            display: block;
            margin-top: 10px;
			object-fit:cover;
        }
		input[type=text] {
			width: 100%;
			border-radius: 30px;
		}
		input[type=email] {
			width: 100%;
			border-radius: 30px;
		}
		input[type=submit] {
			width: 50%;
			align-items: center;
			color: #F6F6F6;
			background-color: rgb(101, 101, 211);
			border-radius: 50px;
		}
    </style>

</head>
<body>
	

<!-- Preloader -->

<div class="preloader">
	<div class="sk-cube-grid">
		<div class="sk-cube sk-cube1"></div>
		<div class="sk-cube sk-cube2"></div>
		<div class="sk-cube sk-cube3"></div>
		<div class="sk-cube sk-cube4"></div>
		<div class="sk-cube sk-cube5"></div>
		<div class="sk-cube sk-cube6"></div>
		<div class="sk-cube sk-cube7"></div>
		<div class="sk-cube sk-cube8"></div>
		<div class="sk-cube sk-cube9"></div>
	</div>
</div>

<!-- Preloader End -->

<!-- back to to button start-->
   <a href="#" id="scroll-top" class="back-to-top-btn"><i class="bi bi-arrow-up"></i></a>
<!-- back to to button end-->


<!-- Header area -->
<header>

<!-- Menu -->
<nav>
	<div class="header-menu-area header-menu-style-2">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-xxl-3 col-xl-2 col-lg-2 col-sm-6 col-6 order-0 order-lg-0">
					<div class="logo text-left">
						<a href="index.php"><img src="assets/images/collegelogo2.png" alt=""></a>
					</div>
				</div>
				<div class="col-xxl-7 col-xl-7 col-lg-7 col-sm-1 col-1 order-2 order-lg-1">
					<a href="javascript:void(0)" class="hidden-lg hamburger">
						<span class="h-top"></span>
						<span class="h-middle"></span>
						<span class="h-bottom"></span>
					</a>
					<nav class="main-nav">
						<div class="logo mobile-ham-logo d-lg-none d-block text-left">
							<a href="index.php"><img src="assets/images/collegelogo2.png" alt=""></a>
						</div>
						<ul>
                            <li>
								<a href="index.php">Home</a>
							</li>
							<li>
								<a href="user1.php" class="active">Dashboard</a>
							</li>
							<li><a href="#" id="editProfileBtn">Edit Profile</a></li>
							
							<li>
								<a href="#notification">Notifications</a>
								
							</li>
							
							<li><a href="logout.html">Logout</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div class="menu-info-wrap d-none d-xxl-block position-absolute">
		<div class="menu-info-shape position-relative">
			
		</div>
		
	</div>
</nav>
</header>
<!-- Menu end -->
<!--  Header area end -->

<!-- Breadcrumb Start -->

<div class="breadcrumb-area positioning">
   <div class="container">
    	<div class="row align-items-center">
         	<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            	<div class="breadcrumb-content">
				<h1>Welcome <?php echo isset($name) ? $name : ''; ?>!!!</h1>
            	</div>
        	</div>
			
      	</div>
 
   	</div>
</div>
<!-- Breadcrumb End -->

<!-- Profile -->
<div class="student-profile py-4">
	<div class="container">
	  <div class="row">
		<div class="col-lg-4">
		  <div class="card shadow-sm">
			<div class="card-header bg-transparent text-center">
			  <img class="profile_img" src="assets/images/users/user-1.jpg" alt="student dp">
			  <h3><?php echo $name; ?></h3>
			</div>
		  </div>
		</div>
		<div class="col-lg-8">
		  <div class="card shadow-sm">
			<div class="card-header bg-transparent border-0">
			  
			</div>
			<div class="card-body pt-0">
			  <table class="table">
			  <tr>
            <th width="30%">Register no</th>
            <td><?php echo isset($reg_no) ? $reg_no : ''; ?></td>
        </tr>
        <tr>
            <th width="30%">Department</th>
            <td><?php echo isset($department) ? $department : ''; ?></td>
        </tr>
        <tr>
            <th width="30%">Year of Graduation</th>
            <td><?php echo isset($graduation_year) ? $graduation_year : ''; ?></td>
        </tr>
        <tr>
            <th width="30%">Current Position</th>
            <td><?php echo isset($current_position) ? $current_position : ''; ?></td>
        </tr>
		<tr>
            <th width="30%">Staff Advisor</th>
            <td><?php echo isset($staff_advisor) ? $staff_advisor : ''; ?></td>
        </tr>
				
			  </table>
			</div>
		  </div>
			<div style="height: 26px"></div>
		  <div class="card shadow-sm">
			<div class="card-header bg-transparent border-0">
			  <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Other Information</h3>
			</div>
			<div class="card-body pt-0">
			<p>Email: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a><br></p>
			</div>
			<div class="card-body pt-0">
			<p>LinkedIn: <a href="<?php echo $linkedin; ?>" target="_blank"><?php echo $linkedin; ?></a><br></p>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
<!-- Profile End -->
<br>
<br>
<div>
<br>
<h1 id="notification" style="text-align: center;">Notifications!!!</h1>
<br>
<br>
<div id="notifications-container">
        <!-- PHP code to display announcements -->
        <?php
        // Fetch announcements from the database
        $sql_announcements = "SELECT * FROM announcements ORDER BY id DESC";
        $result_announcements = mysqli_query($con, $sql_announcements);

        // Check if there are any announcements
        if(mysqli_num_rows($result_announcements) > 0) {
            // Loop through each announcement and display it
            while($announcement = mysqli_fetch_assoc($result_announcements)) {
                echo '<div class="notification">';
                echo '<h3>' . $announcement['title'] . '</h3>';
                echo '<p>' . $announcement['content'] . '</p>';
                echo '<img src="' . $announcement['image'] . '" alt="Announcement Image">';
                echo '</div>';
            }
        } else {
            // If there are no announcements
            echo '<div class="notification">';
            echo '<h3>Welcome to the Dashboard!</h3>';
            echo '<p>There are no new announcements at the moment. Check back later!</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<script>
    function fetchNotifications() {
        fetch('fetch_notifications.php')
            .then(response => response.json())
            .then(data => {
                const notificationsContainer = document.getElementById('notifications-container');
                notificationsContainer.innerHTML = ''; 
                data.forEach(notification => {
                    const notificationDiv = document.createElement('div');
                    notificationDiv.classList.add('notification');
                    notificationDiv.innerHTML = `
                        <h3>${notification.title}</h3>
                        <p>${notification.content}</p>
                        <img src="${notification.image}" alt="Notification Image">
                    `;
                    notificationsContainer.appendChild(notificationDiv);
                });
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }
    fetchNotifications();
</script>

</div>
<!-- Footer Area Start -->

<div class="footer-area footer-area-style-2 footer-area-style-3 mt-120" style="background-color: #F6F6F6;">
	<div class="container">
		<div class="row align-items-center footer-border">
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="footer-logo-wrap" style="background-color: #f6f6f6;">
					<!-- <div class="footer-logo"> -->
						<!-- <a href="index.php"><img src="assets/images/collegelogo2.png" alt=""></a> -->
					<!-- </div> -->
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mobt-24">
				<div class="footer-social text-lg-end">
					<p>Connect With Us</p>
					<ul>
						<li><a href="https://lbt.ac.in/"><i class="bi bi-globe2"></i></a></li>
						<li><a href="https://www.facebook.com/lbsitwpoojappura?mibextid=ZbWKwL"><i class="bi bi-facebook"></i></a></li>
						<li><a href="https://www.instagram.com/lbsitw_trivandrum/"><i class="bi bi-instagram"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
				<div class="footer-wrap">
					<div class="row justify-content-between">
						
						
						<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
							<h2 style="color: #f6f6f6;text-align: right;padding-right:80px;">Made With <span id="boot-icon" class="bi bi-heart-fill" style="font-size: 3rem; color: rgb(255, 0, 0);"></span></h2>
                            <p style="color: white";>Copyright &copy; 2025. Design and Development by WEB TEAM LBSITW</p>
						</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="copy-right-area" style="background: #1A064E;">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="copy-text copy-text-2 text-center">
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer Area End -->




<!-- Jquery JS -->
<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.6.0.min.js"></script>
<!-- Jquery Ui JS -->
<script src="assets/js/jquery-ui.js"></script>
<!-- Bootstrap JS -->		
<script src="assets/js/bootstrap.min.js"></script>
<!-- Owl Carousel JS -->
<script src="assets/js/owl.carousel.min.js"></script>
<!-- Magnific Popup JS -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<!-- Wow JS -->
<script src="assets/js/wow.min.js"></script>
<!-- Odometer JS -->
<script src="assets/js/odometer.min.js"></script>
<script src="assets/js/viewport.jquery.js"></script>
<!-- Main JS -->
<script src="assets/js/main.js"></script>
// Fetch user data
<?php
$sql = "SELECT * FROM registration WHERE reg_no = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $reg_no);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$alumni = mysqli_fetch_assoc($result);
?>
<div id="editProfileModal" class="modal-bg" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Profile</h2>
        <form id="profileForm" method="POST" onsubmit="return validateForm();">
            <label for="ph_no">Contact</label>
            <input type="text" id="ph_no" name="ph_no" pattern="[0-9]{10,15}" title="Enter a valid phone number (10-15 digits)" value="<?= htmlspecialchars($alumni['ph_no']) ?>">

            <label for="address_line1">Address Lane 1:</label>
            <input type="text" id="address_line1" name="address_line1" value="<?= htmlspecialchars($alumni['address_line1']) ?>">

            <label for="address_line2">Address Lane 2:</label>
            <input type="text" id="address_line2" name="address_line2" value="<?= htmlspecialchars($alumni['address_line2']) ?>">

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?= htmlspecialchars($alumni['city']) ?>">

            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?= htmlspecialchars($alumni['state']) ?>">

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?= htmlspecialchars($alumni['country']) ?>">

            <label for="company">Company:</label>
            <input type="text" id="company" name="company" value="<?= htmlspecialchars($alumni['company']) ?>">

            <label for="designation">Current Job Position:</label>
            <input type="text" id="designation" name="designation" value="<?= htmlspecialchars($alumni['designation']) ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($alumni['email']) ?>">

            <input type="submit" value="Save">
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('editProfileModal');
        if (modal) modal.style.display = "flex"; // Use flex to center modal
    }

    function closeModal() {
        const modal = document.getElementById('editProfileModal');
        if (modal) modal.style.display = "none";
    }

    window.onload = function () {
        const editBtn = document.getElementById("editProfileBtn");
        if (editBtn) {
            editBtn.addEventListener("click", function (event) {
                event.preventDefault();
                openModal();
            });
        }

        // Close modal when clicking outside the modal content
        window.onclick = function (event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    }

    function validateForm() {
        const phone = document.getElementById('ph_no').value.trim();
        const email = document.getElementById('email').value.trim();
        const phoneRegex = /^[0-9]{10,15}$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!phoneRegex.test(phone)) {
            alert("Please enter a valid phone number (10–15 digits).");
            return false;
        }

        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        return true;
    }
</script>

</body>

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/case-study.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:42 GMT -->
</html>
