<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['minutes_file'])) {
    $meetingId = $_POST['meeting_id'];
    $file = $_FILES['minutes_file'];

    $targetDir = "uploads/minutes/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true); // create if not exists

    $fileName = basename($file["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        $stmt = $con->prepare("UPDATE meetings SET minutes_file = ? WHERE id = ?");
        $stmt->bind_param("si", $targetFile, $meetingId);
        if ($stmt->execute()) {
            echo "<script>alert('Minutes uploaded successfully'); window.location.href='admin.php';</script>";
        } else {
            echo "Database update failed.";
        }
    } else {
        echo "File upload failed.";
    }
}
?>
