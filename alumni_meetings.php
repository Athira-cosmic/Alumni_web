<?php
session_start();
include("connect.php");
date_default_timezone_set('Asia/Kolkata'); // set your timezone

$today = date('Y-m-d');

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: user1.php");
    exit();
}

$sql = "SELECT * FROM meetings WHERE meeting_date >= CURDATE() ORDER BY meeting_date, meeting_time ASC";
$result = mysqli_query($con, $sql);

// Pagination logic
$perPage = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Total number of meetings
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM meetings");
$totalMeetings = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalMeetings / $perPage);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Alumni Meetings</title>
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
	
        .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
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
    <script>
        function submitOnChange() {
            document.getElementById("filterForm").submit();
        }
    </script>
</head>
<body>
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
    <a href="#" id="scroll-top" class="back-to-top-btn"><i class="bi bi-arrow-up"></i></a>
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
                            <li>
	                            <a href="view_alumni_friends.php">View Alumni</a>
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
</header>


<!-- Breadcrumb Start -->

<div class="breadcrumb-area positioning">
   <div class="container">
    	<div class="row align-items-center">
         	<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
            	<div class="breadcrumb-content">
				<h1> <?php echo isset($name) ? $name : ''; ?>!!!</h1>
            	</div>
        	</div>
			
      	</div>
 
   	</div>
</div>
</header>

<div class="container mt-5">
    <h2>📅 Upcoming Alumni Meetings</h2>
    <div class="row">
        <?php
        $upcoming = mysqli_query($con, "SELECT * FROM meetings WHERE meeting_date >= '$today' ORDER BY meeting_date ASC");
        if (mysqli_num_rows($upcoming) > 0):
            while ($row = mysqli_fetch_assoc($upcoming)):
        ?>
            <div class="col-md-6 mb-4">
                <div class="card p-3 shadow">
                    <h5><?= htmlspecialchars($row['title']) ?></h5>
                    <p><strong>Date:</strong> <?= $row['meeting_date'] ?><br>
                       <strong>Time:</strong> <?= $row['meeting_time'] ?><br>
                       <strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?><br>
                       <strong>Description:</strong><br><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    <span class="badge bg-success">Upcoming</span>
                </div>
            </div>
        <?php endwhile; else: ?>
            <p class="text-muted">No upcoming meetings scheduled.</p>
        <?php endif; ?>
    </div>

    <hr class="my-5">

    <h2>📂 Previous Alumni Meetings (with Minutes)</h2>
    <div class="row">
        <?php
        $previous = mysqli_query($con, "SELECT * FROM meetings WHERE meeting_date < '$today' AND minutes_file IS NOT NULL ORDER BY meeting_date DESC");
        if (mysqli_num_rows($previous) > 0):
            while ($row = mysqli_fetch_assoc($previous)):
        ?>
            <div class="col-md-6 mb-4">
                <div class="card p-3 shadow">
                    <h5><?= htmlspecialchars($row['title']) ?></h5>
                    <p><strong>Date:</strong> <?= $row['meeting_date'] ?><br>
                       <strong>Time:</strong> <?= $row['meeting_time'] ?><br>
                       <strong>Venue:</strong> <?= htmlspecialchars($row['venue']) ?><br>
                       <strong>Description:</strong><br><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    <a href="<?= htmlspecialchars($row['minutes_file']) ?>" class="btn btn-outline-primary" target="_blank">📎 View Minutes (PDF)</a>
                </div>
            </div>
        <?php endwhile; else: ?>
            <p class="text-muted">No previous meeting minutes available.</p>
        <?php endif; ?>
    </div>
</div>
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
  // Remove query params from URL on load to prevent re-filtering on reload
  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('year_of_passout') || urlParams.has('course') || urlParams.has('department')) {
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  };

  // Alumni data passed from PHP
  const alumniData = <?= json_encode($alumniData); ?>;

  // Filters passed from PHP
  const filterYear = <?= json_encode($filter_year); ?>;
  const filterCourse = <?= json_encode($filter_course); ?>;
  const filterDept = <?= json_encode($filter_department); ?>;

  // Convert array of objects to CSV string with a title heading
  function arrayToCSV(data, title) {
    let csv = title + "\r\n\r\n"; // Title + 2 line breaks

    if(data.length === 0) {
        csv += "No data available";
        return csv;
    }

    // Headers
    const headers = Object.keys(data[0]);
    csv += headers.join(",") + "\r\n";

    // Rows
    data.forEach(row => {
        const values = headers.map(h => {
            let val = row[h] ? row[h].toString() : "";
            val = val.replace(/"/g, '""'); // Escape quotes
            if (val.includes(",") || val.includes("\n") || val.includes('"')) {
                val = `"${val}"`;
            }
            return val;
        });
        csv += values.join(",") + "\r\n";
    });

    return csv;
  }

  // Trigger CSV file download
  function downloadCSV(filename, csvContent) {
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  }

  // Compose CSV title based on filters
  function getTitle() {
    let parts = [];
    if(filterYear) parts.push(`Year: ${filterYear}`);
    if(filterCourse) parts.push(`Course: ${filterCourse}`);
    if(filterDept) parts.push(`Department: ${filterDept}`);
    return parts.length > 0 ? `Alumni List - ${parts.join(", ")}` : "Alumni";
  }

  // Download button click handler
  document.getElementById("downloadBtn").addEventListener("click", () => {
    const title = getTitle();
    const csvContent = arrayToCSV(alumniData, title);
    const filename = (title.replace(/\s+/g, '_') || 'alumni') + ".csv";
    downloadCSV(filename, csvContent);
  });
</script>


</body>
</html>