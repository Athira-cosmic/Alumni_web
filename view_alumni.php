<?php
session_start();
include("connect.php");

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

// Collect filters
$filter_year = $_GET['year_of_passout'] ?? '';
$filter_course = $_GET['course'] ?? '';
$filter_department = $_GET['department'] ?? '';

// Build query
$sql = "SELECT * FROM registration WHERE status='approved'";
if ($filter_year) {
    $sql .= " AND year_of_passout = '$filter_year'";
}
if ($filter_course) {
    $sql .= " AND course = '$filter_course'";
}
if ($filter_department) {
    $sql .= " AND department = '$filter_department'";
}

$result = mysqli_query($con, $sql);

// Prepare data for JS CSV export
$alumniData = [];
if (mysqli_num_rows($result) > 0) {
    mysqli_data_seek($result, 0); // rewind pointer
    while ($row = mysqli_fetch_assoc($result)) {
        $address = "{$row['address_line1']}, {$row['address_line2']}, {$row['city']}, {$row['state']}, {$row['country']}";
        $companyPosition = "{$row['company']}, {$row['designation']}";
        $alumniData[] = [
            'Name' => $row['name'],
            'Register No' => $row['reg_no'],
            'Email' => $row['email'],
            'Contact' => $row['ph_no'],
            'Course' => $row['course'],
            'Department' => $row['department'],
            'Passout Year' => $row['year_of_passout'],
            'LinkedIn' => $row['linkedin'],
            'Company & Position' => $companyPosition,
            'Staff Advisor' => $row['staff_advisor'],
            'Address' => $address
        ];
    }
    mysqli_data_seek($result, 0);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Approved Alumni</title>
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
        body { font-family: Arial; padding: 0; background: none; }
        table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        margin-top: 20px;
        }
        th, td {
        padding: 14px 16px;
        border-bottom: 1px solid #e0e0e0;
        text-align: left;
        }
        th {
        background-color: #2c3e50;
        color: #ecf0f1;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        }
        .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        }
        .filter-form select {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
        background-color: #fff;
        transition: border-color 0.3s;
        }
        .filter-form select:focus {
        border-color: lavender;
        outline: none;
        }
        button#downloadBtn,button#clearFiltersBtn {
        padding: 10px 20px;
        font-size: 15px;
        border: none;
        border-radius: 5px;
        background-color: violet;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
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
								<a href="admin_update.php">Update Notification</a>
							</li>
							
							<li>
								<a href="#notify">Announcements</a>
								
							</li>
                            <li>
	                            <a href="view_alumni.php">View Alumni</a>
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
</header>

<h2>Approved Alumni</h2>

<form id="filterForm" method="GET" class="filter-form">
    <label>Passout Year:</label>
    <select name="year_of_passout" onchange="submitOnChange()">
        <option value="">-- Select --</option>
        <?php
        for ($year = date("Y"); $year >= 2000; $year--) {
            $selected = ($filter_year == $year) ? "selected" : "";
            echo "<option value='$year' $selected>$year</option>";
        }
        ?>
    </select>

    <?php if ($filter_year): ?>
        <label>Course:</label>
        <select name="course" onchange="submitOnChange()">
            <option value="">-- Select --</option>
            <option value="BTech" <?= $filter_course == 'BTech' ? 'selected' : '' ?>>BTech</option>
            <option value="MTech" <?= $filter_course == 'MTech' ? 'selected' : '' ?>>MTech</option>
            <option value="PhD" <?= $filter_course == 'PhD' ? 'selected' : '' ?>>PhD</option>
        </select>
    <?php endif; ?>

    <?php if ($filter_year && $filter_course): ?>
        <label>Department:</label>
        <select name="department" onchange="submitOnChange()">
            <option value="">-- Select --</option>
            <option value="CSE" <?= $filter_department == 'CSE' ? 'selected' : '' ?>>CSE</option>
            <option value="ECE" <?= $filter_department == 'ECE' ? 'selected' : '' ?>>ECE</option>
            <option value="IT" <?= $filter_department == 'IT' ? 'selected' : '' ?>>IT</option>
            <option value="Civil" <?= $filter_department == 'Civil' ? 'selected' : '' ?>>Civil</option>
            <option value="AE/I" <?= $filter_department == 'AE/I' ? 'selected' : '' ?>>AE/I</option>
        </select>
    <?php endif; ?>

    <button type="button" id="clearFiltersBtn" onclick="window.location.href='<?= $_SERVER['PHP_SELF'] ?>'">Clear Filters</button>
</form>

<table>
    <tr>
        <th>Name</th>
        <th>Register No</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Course</th>
        <th>Department</th>
        <th>Passout Year</th>
        <th>LinkedIn</th>
        <th>Company & Position</th>
        <th>Staff Advisor</th>
        <th>Address</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $address = "{$row['address_line1']}, {$row['address_line2']}, {$row['city']}, {$row['state']}, {$row['country']}";
            $companyPosition = "{$row['company']}, {$row['designation']}";
            echo "<tr>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>".htmlspecialchars($row['reg_no'])."</td>
                    <td>".htmlspecialchars($row['email'])."</td>
                    <td>".htmlspecialchars($row['ph_no'])."</td>
                    <td>".htmlspecialchars($row['course'])."</td>
                    <td>".htmlspecialchars($row['department'])."</td>
                    <td>".htmlspecialchars($row['year_of_passout'])."</td>
                    <td><a href='".htmlspecialchars($row['linkedin'])."' target='_blank'>View</a></td>
                    <td>".htmlspecialchars($companyPosition)."</td>
                    <td>".htmlspecialchars($row['staff_advisor'])."</td>
                    <td>".htmlspecialchars($address)."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No alumni found.</td></tr>";
    }
    ?>
</table>

<button id="downloadBtn">Download CSV</button>
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