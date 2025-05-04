
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "voting_db");
$username = $_POST['username'];
$password = $_POST['password'];
$stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Invalid credentials.";
}
?>
