<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); 

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "pitch_data"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "❌ Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(["success" => false, "message" => "⚠️ Invalid request method. Use POST."]));
}

$pitcher = $_POST['pitcher'] ?? NULL;
$pitchType = $_POST['pitchType'] ?? NULL;
$result = $_POST['result'] ?? NULL;
$count = $_POST['count'] ?? NULL;
$VELO = $_POST['VELO'] ?? NULL;
$ballInPlay = $_POST['ballInPlay'] ?? NULL;
$flight = $_POST['flight'] ?? NULL;
$hitterHand = $_POST['hitterHand'] ?? NULL;
$out = $_POST['out'] ?? NULL;
$hit = $_POST['hit'] ?? NULL;

$stmt = $conn->prepare("INSERT INTO pitches 
    (pitcher, pitch_type, result, count, VELO, ball_in_play, flight, hitter_hand, `out`, hit) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die(json_encode(["success" => false, "message" => "❌ SQL Prepare failed: " . $conn->error]));
}

$stmt->bind_param("ssssssssss", $pitcher, $pitchType, $result, $count, $VELO, $ballInPlay, $flight, $hitterHand, $out, $hit);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "✅ Data submitted successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "⚠️ SQL Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
