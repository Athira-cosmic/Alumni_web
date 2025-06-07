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
    <title>Approved Alumni</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f0f0f0; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #333; color: white; }
        .filter-form select { padding: 6px; margin-right: 10px; }
        .filter-form { margin-bottom: 20px; }
        button#downloadBtn, button#clearFiltersBtn {
            padding: 10px 20px;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
    <script>
        function submitOnChange() {
            document.getElementById("filterForm").submit();
        }
    </script>
</head>
<body>

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