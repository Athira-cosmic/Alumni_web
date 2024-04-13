<?php
session_start();
include 'connect.php';

// Verify admin session
if (!isset($_SESSION['admin_logged_in'])) {
    header('location:adminlogin.php');
    exit();
}

// Check if announcement ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the announcement from the database
    $sql = "DELETE FROM announcements WHERE id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Announcement deleted successfully.";
    } else {
        echo "Error deleting announcement: " . mysqli_error($con);
    }
} else {
    echo "Invalid announcement ID.";
}
?>
