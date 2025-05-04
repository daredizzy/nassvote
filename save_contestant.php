<?php
$conn = new mysqli("localhost", "root", "", "voting_db");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];

    // Handle image upload
    $photoName = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    $uploadDir = "uploads/";
    $photoPath = $uploadDir . basename($photoName);

    // Move the uploaded file
    if (move_uploaded_file($photoTmp, $photoPath)) {
        $stmt = $conn->prepare("INSERT INTO contestants (name, photo) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $photoName);
        $stmt->execute();
        echo "Contestant added successfully!";
    } else {
        echo "Failed to upload photo.";
    }
}
?>
