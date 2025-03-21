<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = 'localhost'; // Change if using a remote DB
$dbname = 'pitch_data'; // Replace with your actual DB name
$username = 'root'; // Replace with your actual username
$password = ''; // Replace with your actual password

// Establish PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable error reporting
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch data as associative arrays
        PDO::ATTR_EMULATE_PREPARES => false // Use real prepared statements
    ]);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}

// Fetch distinct pitchers from the database
try {
    $stmt = $pdo->query("SELECT DISTINCT pitcher FROM pitches");
    $pitchers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return pitchers list in JSON format
    header('Content-Type: application/json');
    echo json_encode($pitchers);
} catch (PDOException $e) {
    echo "❌ Error fetching pitchers: " . $e->getMessage();
}

// Close the connection (optional with PDO, as it closes automatically when script ends)
$pdo = null;
?>
<?php
// Database connection file
$servername = "localhost"; // Change if needed
$username = "root"; // Your DB username
$password = ""; // Your DB password
$database = "baseball_db"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
