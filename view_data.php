<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'pitch_data');

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Check if the `pitches` table exists
$checkTable = $conn->query("SHOW TABLES LIKE 'pitches'");
if ($checkTable->num_rows == 0) {
    die("❌ Error: The table 'pitches' does not exist in the database.");
}

// Fetch data
$result = $conn->query("SELECT * FROM pitches");

// Check if data exists
if ($result->num_rows > 0) {
    echo "<h2 style='text-align:center;'>Pitch Data Records</h2>";
    echo "<table border='1' style='width:100%; text-align:left; border-collapse:collapse;'>";
    echo "<tr>
            <th>Pitcher</th>
            <th>Pitch Type</th>
            <th>Result</th>
            <th>Count</th>
            <th>VELO</th>
            <th>Ball In Play</th>
            <th>Flight</th>
            <th>Hitter Hand</th>
            <th>Hard Hit</th>
            <th>Out</th>
            <th>Hit</th>
            <th>Timestamp</th>
          </tr>";

    // Display rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['pitcher'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['pitch_type'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['result'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['count'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['VELO'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['ball_in_play'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['flight'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['hitter_hand'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['hardhit'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['out'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['hit'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['timestamp'] ?? "N/A") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center; font-weight:bold;'>No data found in the database.</p>";
}

// Close connection
$conn->close();
?>
