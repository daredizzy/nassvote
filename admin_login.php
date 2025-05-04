
<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
<h2>Admin Login</h2>
<form action="admin_login_process.php" method="POST">
<label>Username:</label><br><input type="text" name="username" required><br><br>
<label>Password:</label><br><input type="password" name="password" required><br><br>
<button type="submit">Login</button>
</form>
</body>
</html>
