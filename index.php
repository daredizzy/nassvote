<!DOCTYPE html>
<html>
<head>
  <title>Vote Now</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #ffecd2, #fcb69f);
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 30px;
    }

    .form-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 100%;
      max-width: 700px;
    }

    h2 {
      text-align: center;
      color: #ff5e62;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    .contestants-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin-bottom: 20px;
    }

    .contestant-card {
      background-color: #fafafa;
      border: 2px solid transparent;
      border-radius: 12px;
      padding: 10px;
      width: 150px;
      text-align: center;
      transition: 0.3s ease;
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .contestant-card:hover {
      border-color: #ff5e62;
      transform: scale(1.02);
    }

    .contestant-card input[type="radio"] {
      margin-bottom: 8px;
    }

    .contestant-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
    }

    .contestant-name {
      font-weight: bold;
      margin-top: 8px;
      color: #333;
    }

    button {
      background: #ff5e62;
      color: white;
      padding: 14px;
      width: 100%;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #e04a4f;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Vote for your Favorite Contestant</h2>
    <form action="initialize_payment.php" method="POST">
      <label>Full Name:</label>
      <input type="text" name="name" required>

      <label>Email:</label>
      <input type="email" name="email" required>

      <label>Phone:</label>
      <input type="text" name="phone" required>

      <label>Choose Number of Votes (₦100 per vote):</label>
      <input type="number" name="vote_quantity" min="1" value="1" required>

      <label>Select Contestant:</label>
      <div class="contestants-container">
        <?php
        $conn = new mysqli("localhost", "root", "", "voting_db");
        $result = $conn->query("SELECT * FROM contestants");
        while ($row = $result->fetch_assoc()) {
            echo "<label class='contestant-card'>";
            echo "<input type='radio' name='contestant_id' value='{$row['id']}' required>";
            echo "<img src='uploads/{$row['photo']}' alt='{$row['name']}'>";
            echo "<div class='contestant-name'>{$row['name']}</div>";
            echo "</label>";
        }
        ?>
      </div>

      <button type="submit">Pay & Vote</button>
    </form>
  </div>
</body>
</html>
