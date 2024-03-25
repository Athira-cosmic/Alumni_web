<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
	include 'connect.php';
	$reg_no=$_POST['reg_no'];
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$ph_no=$_POST['ph_no'];
	$address=$_POST['address'];
	$year_of_passout=$_POST['year_of_passout'];
	$course=$_POST['course'];
	$department=$_POST['department'];
	$company=$_POST['company'];
	$designation=$_POST['designation'];

	$sql="Select * from `registration` where 
	reg_no='$reg_no'";

	$result=mysqli_query($con,$sql);
	if($result){
		$num=mysqli_num_rows($result);
		if($num>0){
			echo "User already exist";
			exit();
		}else{
			$sql="insert into `registration`(reg_no,name,email,password,ph_no,address,year_of_passout,course,department,company,designation)
			values('$reg_no','$name','$email','$password','$ph_no','$address','$year_of_passout','$course','$department','$company','$designation')";
			$result=mysqli_query($con,$sql);
			if($result){
				header('location:signin.php');
			}else{
				die(mysqli_error($con));
			}
		}
	}
}
?>


<!doctype html>
<html lang="en">

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:46 GMT -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Sign Up</title>
	
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
							<li><a href="#section1">About</a></li>
							
							<li>
								<a href="case-study.html">Events</a>
								
							</li>
							
							<li><a href="contact.html">Contact</a></li>
						</ul>
						<div class="menu-btn-wrap d-block d-lg-none">
							<a class="menu-btn" href="signin.php"><i class="bi bi-person"></i> Sign-In</a>
						</div>
						<div class="menu-btn-wrap d-block d-lg-none">
							<a class="menu-btn" href="signup.php" class="active"><i class="bi bi-person"></i> Sign-up</a>
						</div>
					</nav>
				</div>
				<div class="col-xxl-2 col-xl-3 col-lg-3 col-sm-5 col-5 order-1 order-lg-2">
					<div class="menu-btn-wrap ">
						<a class="menu-btn d-none d-lg-block" href="signin.php"><i class="bi bi-person"></i> Sign-In</a>

						<a class="menu-btn d-none d-lg-block" href="signup.php"><i class="bi bi-person"></i> Sign-up</a>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="menu-info-wrap d-none d-xxl-block position-absolute">
		<div class="menu-info-shape position-relative">
			<img src="assets/images/shape/menu.png" alt="">
			<a href="https://themeforest.wprealizer.com/cdn-cgi/l/email-protection#e999869b889a9c8788c780878f86a98e84888085c78a8684"><i class="bi bi-envelope-fill"></i> <span class="__cf_email__" data-cfemail="aadac5d8cbd9dfc4cb84c3c4ccc5eacecfc7c584c9c5c7">[email&#160;protected]</span></a>
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
               <h1>Sign Up</h1>
               
            </div>
         </div>
         <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mobt-24">
            <div class="breadcrumb-link text-start text-lg-end">
               <h4><a href="index.php">Home</a> > Sign Up</h4>
            </div>
         </div>
      </div>
   </div>
	<img class="shape breadcrumb-round-1 d-lg-block d-none" src="assets/images/shape/breadcrumb-round.png" alt="">
</div>

<!-- Breadcrumb End -->


</header>
<!--  Header area end -->





<!-- Contact From Start -->

<div class="contact-area mt-120">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            <div class="contact-title">
               <h2>Sign Up Now!</h2>
               
               
            </div>
            <form action="signup.php" method="post" class="contact-input mt-5 position-relative">
               <div class="row">
                <label>Registration Number</label>
                <input type="text" name="reg_no" placeholder="Register no">
                <br>
                <br>
				<label>Name</label>
                <input type="text" name="name" placeholder="Name">
                <br>
                <br>
                <label>E-Mail</label>
                <input type="email"  id="email"name="email" placeholder="Email">
                <br>
                <br>
                <label>Password</label>
                <input type="password"  id="password"name="password" placeholder="Password" >
                <br>
                <br>
                <label>Contact</label>
                <input type="text" name="ph_no"  placeholder="Contact">
                <br>
                <br>
                <label>Address</label><br>
                <textarea rows="5" cols="80" name="address" placeholder="Address">
                </textarea><br><br>
                <label>Year of Passout</label>
                <input  type="year" name=year_of_passout placeholder="Year"><br><br>
                <label>Course</label>
                <select name="course">
                    <option>Select</option>
                    <option>BTech</option>
					<option>MTech</option>
					<option>PhD</option>
                </select>
                <label>Department</label>
                <select name="department">
                    <option>Select</option>
                    <option>CS</option>
                    <option>IT</option>
                    <option>EC</option>
                    <option>AEI</option>
                    <option>Civil</option>
                </select>
                <br>
                <br>
                
                <label>Company</label>
                <input type="text" name="company" placeholder="Company">
                <br>
                <br>
                
                <label>Designation</label>
                <input type="text" name="designation" placeholder="Designation">
                <br>
                <br>
                
                  
                  <div class="col-xl-7 col-lg-10 col-sm-12 col-12">
                     
                  </div>
                  <div class="contact-btn-wrap mt-5">
                     <button type="submit" class="common-btn">Sign Up</button>
                  </div>
                  <p class="form-message"></p>
               </div>
            </form>
			</div>
		</div>
	</div>
</div>

<!-- Contact From End -->


<!-- Footer Area Start -->
<div class="footer-area footer-area-style-2 footer-area-style-3 mt-120" style="background-color: #F6F6F6;">
	<div class="container">
		<div class="row align-items-center footer-border">
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="footer-logo-wrap" style="background-color: #f6f6f6;">
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

</body>

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:46 GMT -->
</html>