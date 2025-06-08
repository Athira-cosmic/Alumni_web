<li?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'connect.php';

    // Fetch and sanitize all fields
    $reg_no = mysqli_real_escape_string($con, $_POST['reg_no']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $ph_no = mysqli_real_escape_string($con, $_POST['ph_no']);
    $address_line1 = mysqli_real_escape_string($con, $_POST['address_line1']);
    $address_line2 = mysqli_real_escape_string($con, $_POST['address_line2']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $year_of_passout = mysqli_real_escape_string($con, $_POST['year_of_passout']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
	$staff_advisor = mysqli_real_escape_string($con, $_POST['staff_advisor']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);

    $status = 'pending';

    $sql = "INSERT INTO registration 
        (reg_no, name, email, linkedin, password, ph_no, address_line1, address_line2, city, state, postal_code, country, year_of_passout, course, department, staff_advisor, company, designation, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($stmt, "ssssssssssssissssss", 
    $reg_no, $name, $email, $linkedin, $password, $ph_no, $address_line1, $address_line2, $city, $state, $postal_code, $country, $year_of_passout, $course, $department, $staff_advisor, $company, $designation, $status);

		if (mysqli_stmt_execute($stmt)) {
    		header('Location: signin.php');
    		exit();
		} else {
    		echo "Error: " . mysqli_error($con);
		}

		mysqli_stmt_close($stmt);
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
	<style>
    	.form-step { display: none; }
    	.form-step.active { display: block; }
  		.common-btn, .next-btn, .prev-btn {
    	padding: 8px 16px;
    	margin-top: 10px;
    	cursor: pointer;
  		}
		input, select {
  			width: 100%;
  			padding: 10px;
  			border: 1px solid #ccc;
  			border-radius: 4px;
  			font-size: 16px;
  			font-family: inherit;
  			box-sizing: border-box;
			}

		select {
  			appearance: none; /* Removes default dropdown arrow (optional) */
  			background-color: #fff;
  			background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
  			background-repeat: no-repeat;
  			background-position-x: 98%;
  			background-position-y: center;
  			padding-right: 30px; /* Space for the arrow */
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
							<li><a href="about-us.html">About</a></li>
							
							<li>
								<a href="case-study.html">Events</a>
								
							</li>
							
							<li><a href="contact.html">Contact</a></li>
							<li><a class="menu-btn" href="signin.php"><i class="bi bi-person"></i> Sign-In</a></li>
							<li><a class="menu-btn" href="signup.php" class="active"><i class="bi bi-person"></i> Sign-up</a></li>
						</ul>	
					</nav>
				</div>
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
               <h1>Sign Up</h1>
               
            </div>
         </div>
         <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mobt-24">
            <div class="breadcrumb-link text-start text-lg-end">
               
            </div>
         </div>
      </div>
   </div>
	
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
            <form id="signupForm" action="signup.php" method="post" class="contact-input mt-5 position-relative">

  				<!-- Step 1 -->
  				<div class="form-step active">
    				<h3>Basic Info</h3>
    				<label>Registration Number</label>
    				<input type="text" name="reg_no" placeholder="Register no" required>
    				<br><br>
    				<label>Name</label>
    				<input type="text" name="name" placeholder="Name" required>
    				<br><br>
    				<label>E-Mail</label>
    				<input type="email" name="email" placeholder="Email" required>
    				<br><br>
    				<label>LinkedIn</label>
    				<input type="text" name="linkedin" placeholder="Linkedin">
    				<br><br>
    				<button type="button" class="next-btn">Next</button>
  				</div>

  				<!-- Step 2 -->
  				<div class="form-step">
    				<h3>Security & Contact</h3>
    				<label>Password</label>
    				<input type="password" name="password" placeholder="Password" required>
    				<br><br>
    				<label>Contact</label>
    				<input type="tel" name="ph_no" placeholder="Contact" pattern="[0-9]{10}" required>
    				<br><br>
    				<button type="button" class="prev-btn">Previous</button>
    				<button type="button" class="next-btn">Next</button>
  				</div>

  				<!-- Step 3 -->
  				<div class="form-step">
    				<h3>Address</h3>
   		 			<label>Address Line 1</label><br>
    				<input name="address_line1" placeholder="Address Line 1" required>
    				<br><br>
    				<label>Address Line 2</label><br>
    				<input name="address_line2" placeholder="Address Line 2">
    				<br><br>
    				<label>City</label><br>
    				<input name="city" placeholder="City" required>
    				<br><br>
    				<label>State</label><br>
    				<input name="state" placeholder="State" required>
    				<br><br>
    				<label>Country</label><br>
    				<input name="country" placeholder="Country" required>
    				<br><br>
    				<label>Pincode</label><br>
    				<input name="postal_code" placeholder="Pincode" required>
    				<br><br>
    				<button type="button" class="prev-btn">Previous</button>
    				<button type="button" class="next-btn">Next</button>
  				</div>

  				<!-- Step 4 -->
  				<div class="form-step">
    				<h3>Education & Work</h3>
    				<label>Year of Passout</label>
    				<select name="year_of_passout" required>
    					<option value="">Select Year</option>
    					<?php
        					$currentYear = date("Y");
        					for ($year = 2004; $year <= $currentYear; $year++) {
            				echo "<option value='$year'>$year</option>";
        					}
    					?>
					</select>
    				<label>Course</label>
    				<select name="course" required>
      					<option value="">Select</option>
      					<option value="BTech">BTech</option>
      					<option value="MTech">MTech</option>
      					<option value="PhD">PhD</option>
    				</select>
    				<br><br>
    				<label>Department</label>
    				<select name="department" required>
      					<option value="">Select</option>
      					<option value="CSE">CSE</option>
      					<option value="IT">IT</option>
      					<option value="ECE">ECE</option>
      					<option value="ERE">ERE</option>
      					<option value="AE&I">AE&I</option>
      					<option value="Civil">Civil</option>
    				</select>
    				<br><br>
					<label>Staff Advisor</label>
					<input type="text" name="staff_advisor" placeholder="Enter Staff Advisor Name">
					<br><br>
    				<label>Company</label>
    				<input type="text" name="company" placeholder="Company">
    				<br><br>
    				<label>Designation</label>
    				<input type="text" name="designation" placeholder="Designation">
   					 <br><br>
    				<button type="button" class="prev-btn">Previous</button>
    				<button type="submit" class="common-btn">Sign Up</button>
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
<script>
  const nextBtns = document.querySelectorAll('.next-btn');
  const prevBtns = document.querySelectorAll('.prev-btn');
  const formSteps = document.querySelectorAll('.form-step');
  let currentStep = 0;

  nextBtns.forEach(button => {
    button.addEventListener('click', () => {
      if (validateStep(currentStep)) {
        formSteps[currentStep].classList.remove('active');
        currentStep++;
        formSteps[currentStep].classList.add('active');
      }
    });
  });

  prevBtns.forEach(button => {
    button.addEventListener('click', () => {
      formSteps[currentStep].classList.remove('active');
      currentStep--;
      formSteps[currentStep].classList.add('active');
    });
  });

  function validateStep(step) {
    const inputs = formSteps[step].querySelectorAll('input, select');
    for (let input of inputs) {
      if (input.hasAttribute('required') && !input.value) {
        alert('Please fill all required fields');
        return false;
      }
    }
    return true;
  }
</script>

</body>

<!-- Mirrored from themeforest.wprealizer.com/html-educoda-preview/educoda/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 05:52:46 GMT -->
</html>