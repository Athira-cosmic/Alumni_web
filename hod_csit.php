<?php
session_start();
include("connect.php");

// Check login
if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['reg_no'])) {
    header('location:adminlogin.php');
    exit();
}

// Map reg_no to admin_id
$admin_reg_no = $_SESSION['reg_no'];
$admin_id = null;

switch ($admin_reg_no) {
    case 'CSIT2001':
        $admin_id = 2; break;
    case 'ECERE2001':
        $admin_id = 3; break;
    case 'CE2001':
        $admin_id = 4; break;
    default:
        header('location:admin.php'); exit();
}

// Approve
if (isset($_GET['approve_alumni'])) {
    $reg_no = $_GET['approve_alumni'];
    $stmt = $con->prepare("UPDATE registration SET status='approved' WHERE reg_no = ?");
    $stmt->bind_param("s", $reg_no);
    $stmt->execute();
    header("Location: hod_csit.php");
    exit();
}

// Reject
if (isset($_GET['reject_alumni'])) {
    $reg_no = $_GET['reject_alumni'];
    $stmt = $con->prepare("UPDATE registration SET status='rejected' WHERE reg_no = ?");
    $stmt->bind_param("s", $reg_no);
    $stmt->execute();
    header("Location: hod_csit.php");
    exit();
}

// Fetch alumni
function fetchPendingAlumni($con, $admin_id) {
    $departments = [];

    switch ($admin_id) {
        case 2: $departments = ['CSE', 'IT']; break;
        case 3: $departments = ['ECE', 'AE&I', 'ERE']; break;
        case 4: $departments = ['Civil']; break;
        default: return [];
    }

    $placeholders = implode(',', array_fill(0, count($departments), '?'));
    $types = str_repeat('s', count($departments));

    $sql = "SELECT * FROM registration WHERE status='pending' AND department IN ($placeholders)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$departments);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

$pending_alumni = fetchPendingAlumni($con, $admin_id);
?>

// Verify admin session

?>

<!doctype html>
<html lang="en">

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/case-study.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:42 GMT -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>HOD-CSE Dashboard</title>
	
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
		
		.main-nav ul {
  			display: flex;
  			flex-wrap: nowrap;              /* Prevent wrapping */
  			overflow-x: auto;               /* Allow horizontal scroll */
  			white-space: nowrap;            /* Force items to stay inline */
  			gap: 20px;
  			padding: 20px 0;
  			margin: 0;
  			list-style: none;
  			scrollbar-width: none;          /* Hide scrollbar for Firefox */
		}


		.main-nav ul li {
  			flex-shrink: 0;                 /* Prevent shrinking */
		}
	
    /* Card Styles */
	.card {
        background-color: 1px solid #19075f;
        border-radius: 15px;
        box-shadow: 0 2px 30px rgba(9, 2, 82, 0.637);
        margin-bottom: 35px;
        padding: 25px;
    }
    .card-body {
        padding: 20px;
    }
    .card-widgets {
        margin-bottom: 10px;
    }
    .card-widgets a {
        color: #333;
        text-decoration: none;
        margin-right: 10px;
    }
	
	/* 	General Styles */

    .header-title {
        color: #333;
        font-size: 30px;
        margin-bottom: 15px;
    }
    p {
        color: #57487e;
        margin-bottom: 20px;
    }

    #world-map-markers {
        height: 50px;
        background-color: #eeebf5;
        border-radius: 10px;
    }
	button{
		border-radius: 50px;
	}
	input[type=file]{
		border-radius: 20px;
		background-color: #57487e;
		color: white;
		width: 20%;
	}
	button[type=submit]{
		border-radius: 20px;
		background-color: #57487e;
		color: white;
		width: 10%;
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
						<a href="index.html"><img src="assets/images/collegelogo2.png" alt=""></a>
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
							<a href="index.html"><img src="assets/images/collegelogo2.png" alt=""></a>
						</div>
						<ul>
                            <li><a href="index.php">Home</a></li>
							<li>
								<a href="hod_csit.php">Dasboard</a>
							</li>
                            <li>
	                            <a href="view_csit.php">View Alumni</a>
                            </li>
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
<!-- Menu end -->


<!-- Breadcrumb Start -->

<div class="breadcrumb-area positioning">
   <div class="container">
    	<div class="row align-items-center">
         	<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            	<div class="breadcrumb-content">
               		<h1>Admin-LBSITW</h1>
            	</div>
        	</div>
      	</div>
 
   	</div>
</div>
<!-- Breadcrumb End -->


</header>
<!--  Header area end -->

<br>
 <!-- Membership Request -->
 <div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-0">Member Requests:</h4><br><br>
                <div id="memberRequests" class="row">
                    <?php
                    $requests = fetchPendingAlumni($con, $admin_id);
                    foreach ($requests as $request) {
                        echo "<div class='col-lg-4 col-xl-4'>";
                        echo "<div class='card text-center'>";
                        echo "<div class='card-body'>";
                        echo "<img src='assets/images/users/user-1.jpg' class='rounded-circle avatar-lg img-thumbnail' alt='profile-image'>";
                        echo "<h4 class='mb-0'>" . $request['name'] . "</h4>";
                        echo "<p class='text-muted'>" . $request['reg_no'] . "</p>";
                        echo "<a href='hod_csit.php?approve_alumni=" . $request['reg_no'] . "' class='btn btn-success btn-xs'>ACCEPT</a> ";
                        echo "<a href='hod_csit.php?reject_alumni=" . $request['reg_no'] . "' class='btn btn-danger btn-xs'>REJECT</a>";
                        echo "</div></div></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Membership Request End -->
<br>


 
<!-- Footer Area Start -->

<div class="footer-area footer-area-style-2 footer-area-style-3 mt-120" style="background-image: url('assets/images/shape/footer-2.jpg');">
	<div class="container">
		<div class="row align-items-center footer-border">
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="footer-logo-wrap" style="background-image: url('assets/images/shape/footer-1.jpg');">
					<!-- <div class="footer-logo"> -->
						<!-- <a href="index.html"><img src="assets/images/collegelogo2.png" alt=""></a> -->
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
							<h2 style="color: black;text-align: right;padding-right:80px;">Made With <span id="boot-icon" class="bi bi-heart-fill" style="font-size: 3rem; color: rgb(255, 0, 0);"></span></h2>
							<p style="color: black";>Copyright &copy; 2025. Design and Development by WEBCRAFTERS LBSITW</p>
						</div>
						
						</div>
					</div>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
    $('#announcementForm').submit(function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'create_announcement.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#success_message').html("Submitting...");
            },
            success: function(response) {
                $('#success_message').html(response);
                setTimeout(function() {
                    $('#success_message').fadeOut();
                }, 5000);
                $('#announcementForm')[0].reset();
            },
            error: function(xhr, status, error) {
                $('#success_message').html('<span style="color:red;">Error submitting announcement.</span>');
                console.error(xhr.responseText);
            }
        });
    });
});
</script>


</body>

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/case-study.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:42 GMT -->
</html>