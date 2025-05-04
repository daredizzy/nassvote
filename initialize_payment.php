<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$contestant_id = $_POST['contestant_id'];
$vote_quantity = max(1, intval($_POST['vote_quantity'])); // Make sure it's at least 1
$amount = $vote_quantity * 100 * 100; // Amount in kobo (Paystack uses kobo)

// Save voter to DB (optional but recommended)
$stmt = $conn->prepare("INSERT INTO voters (name, email, phone, contestant_id, vote_quantity) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $name, $email, $phone, $contestant_id, $vote_quantity);
$stmt->execute();
$stmt->close();

// Generate unique reference
$ref = uniqid("vote_");

// Initialize Paystack payment
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'amount' => $amount,
        'email' => $email,
        'reference' => $ref,
        'callback_url' => "http://localhost/complete_voting_system/verify_payment.php",
        'metadata' => [
            'name' => $name,
            'phone' => $phone,
            'contestant_id' => $contestant_id,
            'vote_quantity' => $vote_quantity
        ]
    ]),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer sk_live_d1b4f801cbd8c6596a428c2f22410dc3195ae5bc", // Replace with your Paystack secret key
        "Content-Type: application/json"
    ],
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    die("Curl Error: $err");
}

$result = json_decode($response, true);

if (isset($result['data']['authorization_url'])) {
    header("Location: " . $result['data']['authorization_url']);
    exit();
} else {
    echo "Payment initialization failed. Try again.";
}
?>
