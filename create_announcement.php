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
                // File uploaded successfully, now insert the file path into the database
                $image_path = $target_file;

                // Insert the image path into the database
                $sql = "INSERT INTO announcements (title, image) VALUES ('$title', '$image_path')";
                if (mysqli_query($con, $sql)) {
                    echo "Announcement created successfully.";
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
?>
