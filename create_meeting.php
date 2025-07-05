<?php
session_start();
include 'connect.php';

// Check admin session
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adminlogin.php');
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $title = trim(mysqli_real_escape_string($con, $_POST['title']));
    $meeting_date = $_POST['meeting_date'];
    $meeting_time = $_POST['meeting_time'];
    $venue = trim(mysqli_real_escape_string($con, $_POST['venue']));
    $description = trim(mysqli_real_escape_string($con, $_POST['description']));

    // Insert into meetings table
    $sql = "INSERT INTO meetings (title, meeting_date, meeting_time, venue, description) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $title, $meeting_date, $meeting_time, $venue, $description);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Meeting scheduled successfully.'); window.location.href='admin.php#meetings';</script>";
    } else {
        echo "<script>alert('Failed to schedule meeting.'); window.history.back();</script>";
    }

    mysqli_stmt_close($stmt);
}
?>
