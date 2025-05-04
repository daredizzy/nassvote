<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "voting_db");

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM contestants");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">

</head>
<body>
<centere><h2>Contestants</h2></centere>
<table border="1">
<tr><th>Name</th><th>Votes</th><th>Action</th></tr>

<?php if ($result && $result->num_rows > 0): ?>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['votes']) ?></td>
      <td>
        <a href="delete_contestant.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this contestant?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
<?php else: ?>
  <tr><td colspan="3">No contestants found.</td></tr>
<?php endif; ?>

</table>
</body>
</html>
