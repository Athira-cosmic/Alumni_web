<?php
include 'connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if title and content are set and not empty
    if (isset($_POST['title']) && !empty(trim($_POST['title'])) && isset($_POST['write_something']) && !empty(trim($_POST['write_something']))) {
        $title = trim($_POST['title']);
        $content = trim($_POST['write_something']); // Fetch content from input field

        // Check if image file is uploaded
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            
            // Move the uploaded file to the uploads directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // File uploaded successfully, now insert the file path into the database
                $image_path = $target_file;

                // Insert the image path into the database along with title and content
                $sql = "INSERT INTO announcements (title, content, image) VALUES ('$title', '$content', '$image_path')";
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
        echo "Title and content are required.";
    }
}
?>
