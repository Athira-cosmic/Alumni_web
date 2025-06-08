<?php
session_start();
include 'connect.php';

// Verify admin session
if (!isset($_SESSION['admin_logged_in'])) {
    header('location:adminlogin.php');
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if title is set and not empty
    if (isset($_POST['title']) && !empty(trim($_POST['title']))) {
        $title = trim($_POST['title']);

        // Check if image file is uploaded
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            
            // Move the uploaded file to the uploads directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File uploaded successfully, now update the announcement in the database
                $image_path = $target_file;
                $id = $_GET['id'];

                // Update the announcement in the database
                $sql = "UPDATE announcements SET title='$title', image='$image_path' WHERE id='$id'";
                if (mysqli_query($con, $sql)) {
                    echo "Announcement updated successfully.";
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Please select an image file.";
        }
    } else {
        echo "Title is required.";
    }
}

// Fetch announcement data for prefilled form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT title FROM announcements WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
    } else {
        echo "Announcement not found.";
    }
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
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 10px;
        }
    </style>
<head>
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
								<a href="admin.php">Admin Dashboard</a>
							</li>
							<li><a href="admin_update.php">Update Notification</a></li>
							
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

<div class="row" id="notify">
    <div class="col-xl-6" style="width:100%">
        <div class="card">
            <div class="card-body">
                <div class="card-widgets">
                    <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                    <a data-bs-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                    <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                </div>
                <h4 class="header-title mb-0">Edit Announcement:</h4><br><br>
                <form action="edit_announcement.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="validationCustom01" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="validationCustom01" placeholder="Events" value="<?php echo $title; ?>" required />
                </div>
                <label>Image</label>
                <input type="file" name="image"><br><br>
                <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1" style="width: 100%;">
                    <!-- new post -->
                    <div class="card">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="#newpost" data-bs-toggle="tab" aria-expanded="false" class="nav-link active px-3 py-2">
                                        <i class="mdi mdi-pencil-box-multiple font-18 d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Edit Announcement</span>
                                    </a>
                                </li>
                                
                                
                            </ul> <!-- end nav-->
                            <div class="tab-content pt-0">
                                <div class="tab-pane show active p-3" id="newpost">
                                    <!-- comment box -->
                                    <div class="border rounded">
                                        <form action="#" class="comment-area-box">
                                            <textarea rows="4" class="form-control border-0 resize-none" placeholder="Write something...."></textarea>
                                            <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-image-outline"></i></a>
                                                    <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-crosshairs-gps"></i></a>
                                                    <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i class="mdi mdi-attachment"></i></a>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success"><i class='mdi mdi-send-outline me-1'></i>Update</button>
                                            </div>
                                        </form>
                                    </div> <!-- end .border-->
                                    <!-- end comment box -->
                                </div> <!-- end preview-->
                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                    <!-- end new post -->
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->

</div>
<!-- Annoucement ends -->
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

</body>

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/case-study.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:42 GMT -->
</html>