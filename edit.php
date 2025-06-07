<?php
session_start();
include("connect.php");

// Assume this is the logged-in alumni’s register number
// You can set this from session during login
$reg_no = $_SESSION['reg_no'] ?? 'CSE2021A001'; // fallback for testing

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['regNumber'])) {
    $ph_no = $_POST['ph_no'];
    $address_line1 = $_POST['address_line1'];
    $ddress_line2 = $_POST['ddress_line2'];
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
    mysqli_stmt_bind_param($stmt, "ssssssssss", $ph_no, $address_line1, $address_line1, $city, $state, $country, $company, $designation, $email, $reg_no);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile updated successfully'); window.location.href=window.location.href;</script>";
    } else {
        echo "<script>alert('Failed to update profile');</script>";
    }

    mysqli_stmt_close($stmt);
}

// Fetch user data
$sql = "SELECT * FROM registration WHERE reg_no = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $reg_no);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$alumni = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumni Profile</title>
    <style>
        .modal-bg {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 80px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 30px;
            border: 1px solid #888;
            width: 400px;
            border-radius: 8px;
            position: relative;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
        label { font-weight: bold; }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #004c99;
            color: white;
            border: none;
            cursor: pointer;
        }
        #editProfileBtn {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background: #0066cc;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- Trigger Button -->
<a href="#" id="editProfileBtn">Edit Profile</a>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal-bg">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Profile</h2>
        <form id="profileForm" method="POST">
            <label for="ph_no">Contact</label>
            <input type="text" id="ph_no" name="ph_no" value="<?= htmlspecialchars($alumni['ph_no']) ?>">

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
        document.getElementById('editProfileModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('editProfileModal').style.display = "none";
    }

    document.getElementById("editProfileBtn").addEventListener("click", function(event) {
        event.preventDefault();
        openModal();
    });

    // Close modal when clicking outside content
    window.onclick = function(event) {
        let modal = document.getElementById('editProfileModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>