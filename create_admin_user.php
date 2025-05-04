
<?php
$conn = new mysqli("localhost", "root", "", "voting_db");
$username = "admin";
$password = "admin123";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Failed to create admin.";
}
?>
