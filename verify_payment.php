<?php
if (!isset($_GET['reference'])) {
    die("No payment reference supplied.");
}

$ref = $_GET['reference'];
$secret_key = 'sk_live_d1b4f801cbd8c6596a428c2f22410dc3195ae5bc'; // Replace with your secret key

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.paystack.co/transaction/verify/' . $ref);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key",
    "Cache-Control: no-cache",
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    die('cURL error: ' . curl_error($ch));
}

curl_close($ch);

// Decode response
$result = json_decode($response, true);

// Debug (optional):
// print_r($result); exit();

if (isset($result['data']) && $result['data']['status'] == 'success') {
    $conn = new mysqli("localhost", "root", "", "voting_db");

    $ref = $conn->real_escape_string($ref);
    $query = $conn->query("SELECT * FROM voters WHERE payment_ref='$ref' LIMIT 1");

    if ($query && $query->num_rows > 0) {
        $voter = $query->fetch_assoc();
        $contestant_id = intval($voter['contestant_id']);

        // Update contestant vote
        $conn->query("UPDATE contestants SET votes = votes + 1 WHERE id = $contestant_id");

        echo "Vote successful. Thank you!";
    } else {
        echo "Voter not found.";
    }
} else {
    echo "Payment verification failed.";
    if (isset($result['message'])) {
        echo "<br>Error: " . $result['message'];
    }
}
?>
