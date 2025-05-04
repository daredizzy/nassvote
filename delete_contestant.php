
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "voting_db");

$id = intval($_GET['id']);

// Optional: Get photo to delete file
$result = $conn->query("SELECT photo FROM contestants WHERE id = $id");
if ($result && $row = $result->fetch_assoc()) {
    $photoPath = $row['photo'];
    if (file_exists($photoPath)) {
        unlink($photoPath); // Delete photo file
    }
}

// Delete from database
$conn->query("DELETE FROM contestants WHERE id = $id");

header("Location: admin_dashboard.php");
exit();
?>
