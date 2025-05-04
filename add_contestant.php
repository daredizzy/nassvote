
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Contestant</title></head>
<body>
<h2>Add New Contestant</h2>
<form action="save_contestant.php" method="POST" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Photo:</label>
    <input type="file" name="photo" accept="image/*" required><br><br>

    <input type="submit" value="Add Contestant">
</form>

</body>
</html>
