<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "baseball_db"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} else {
    echo "✅ Database Connected Successfully!";
}

}

// Fetch player stats data for calculation
$sql = "SELECT * FROM player_stats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize total counters
    $total_ip = 0;  // Innings Pitched
    $total_er = 0;  // Earned Runs
    $total_h = 0;   // Hits
    $total_bb = 0;  // Walks (BB)
    $total_so = 0;  // Strikeouts (SO)
    $total_hr = 0;  // Home Runs (HR)
    $total_w = 0;   // Wins (W)
    $total_l = 0;   // Losses (L)
    $total_cg = 0;  // Complete Games (CG)
    $total_sho = 0; // Shutouts (SHO)
    $total_sv = 0;  // Saves (SV)
    $total_doubles = 0;
    $total_triples = 0;
    $total_singles = 0;

    // Calculate totals
    while ($row = $result->fetch_assoc()) {
        $total_ip += $row['IP'];
        $total_er += $row['ER'];
        $total_h += $row['H'];
        $total_bb += $row['BB'];
        $total_so += $row['SO'];
        $total_hr += $row['HR'];
        $total_w += $row['W'];
        $total_l += $row['L'];
        $total_cg += $row['CG'];
        $total_sho += $row['SHO'];
        $total_sv += $row['SV'];
        $total_doubles += $row['DOUBLES'];
        $total_triples += $row['TRIPLES'];
        $total_singles += $row['SINGLES'];
    }

    // Calculate stats
    $era = ($total_er * 9) / ($total_ip ?: 1); // Earned Run Average (ERA)
    $whip = ($total_bb + $total_h) / ($total_ip ?: 1); // Walks + Hits per Inning Pitched (WHIP)
    $h9 = ($total_h * 9) / ($total_ip ?: 1); // Hits per 9 innings (H9)
    $hr9 = ($total_hr * 9) / ($total_ip ?: 1); // Home Runs per 9 innings (HR9)
    $bb9 = ($total_bb * 9) / ($total_ip ?: 1); // Walks per 9 innings (BB9)
    $so9 = ($total_so * 9) / ($total_ip ?: 1); // Strikeouts per 9 innings (SO9)
    $so_bb = $total_so / ($total_bb ?: 1); // Strikeouts to Walks Ratio (SO/BB)
    $wl_pct = ($total_w) / (($total_w + $total_l) ?: 1); // Win-Loss Percentage (W-L%)

    // Display calculated stats
    echo "<h2>Pitching Statistics</h2>";
    echo "<p>ERA (Earned Run Average): " . number_format($era, 2) . "</p>";
    echo "<p>WHIP (Walks + Hits per Inning Pitched): " . number_format($whip, 2) . "</p>";
    echo "<p>H9 (Hits per 9 innings): " . number_format($h9, 2) . "</p>";
    echo "<p>HR9 (Home Runs per 9 innings): " . number_format($hr9, 2) . "</p>";
    echo "<p>BB9 (Walks per 9 innings): " . number_format($bb9, 2) . "</p>";
    echo "<p>SO9 (Strikeouts per 9 innings): " . number_format($so9, 2) . "</p>";
    echo "<p>SO/BB (Strikeouts to Walks Ratio): " . number_format($so_bb, 2) . "</p>";
    echo "<p>W-L% (Win-Loss Percentage): " . number_format($wl_pct, 3) . "</p>";
} else {
    echo "❌ No records found for stats calculation.";
}

// Fetch player stats from the 'player_stats' table to display in a table
$sql = "SELECT * FROM player_stats ORDER BY DATE DESC"; // Ensure 'DATE' column exists
$result = $conn->query($sql);

// Check if records exist to display
if ($result->num_rows > 0) {
    echo "<h2 style='text-align:center;'>Player Stats Records</h2>";
    echo "<table border='1' style='width:100%; text-align:left; border-collapse:collapse;'>";
    echo "<tr>
            <th>Opponent</th>
            <th>Date</th>
            <th>WAR</th>
            <th>W</th>
            <th>L</th>
            <th>ERA</th>
            <th>IP</th>
            <th>H</th>
            <th>R</th>
            <th>ER</th>
            <th>HR</th>
            <th>BB</th>
            <th>SO</th>
          </tr>";

    // Output data for each player
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["OPPONENT"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["DATE"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["WAR"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["W"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["L"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["ERA"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["IP"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["H"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["R"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["ER"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["HR"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["BB"] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row["SO"] ?? "N/A") . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center; font-weight:bold;'>No player stats found in the database.</p>";
}

// Close the connection
$conn->close();
?>
SHOW TABLES LIKE 'player_stats';
