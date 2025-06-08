<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && !empty(trim($_POST['title'])) && isset($_POST['write_something']) && !empty(trim($_POST['write_something']))) {
        $title = trim($_POST['title']);
        $content = trim($_POST['write_something']);
        $image_path = null;

        // Check if an image is uploaded
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $target_dir = "uploads/";
            $filename = time() . "_" . basename($_FILES["image"]["name"]); // Avoid name conflicts
            $target_file = $target_dir . $filename;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        }

        // Prepare query (with or without image)
        $stmt = mysqli_prepare($con, "INSERT INTO announcements (title, content, image) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $title, $content, $image_path);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-success'>Announcement created successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($con) . "</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Title and content are required.";
    }
}
?>