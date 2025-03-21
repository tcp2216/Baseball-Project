<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require 'db_connect.php'; // Use a single connection

// Get pitcher name from request
$pitcher = $_GET['pitcher'] ?? '';

if (!empty($pitcher)) {
    // Get total pitches for the selected pitcher
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_pitches FROM pitches WHERE pitcher = ?");
    $stmt->execute([$pitcher]);
    $total_pitches = $stmt->fetchColumn() ?? 0;

    if ($total_pitches > 0) {
        // Get pitch distribution by position (1-9)
        $stmt = $pdo->prepare("
            SELECT ball_in_play, COUNT(*) AS count
            FROM pitches
            WHERE pitcher = ?
            GROUP BY ball_in_play
            ORDER BY ball_in_play
        ");
        $stmt->execute([$pitcher]);
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $position = $row['ball_in_play'];
            $count = $row['count'];
            $percentage = round(($count / $total_pitches) * 100, 2);
            $data[] = [
                'position' => $position,
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        // Return JSON response
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "⚠️ No data found for this pitcher."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "⚠️ No pitcher selected!"]);
}
?>
<?php
require 'db_connect.php';

$stmt = $pdo->query("SELECT DISTINCT pitcher FROM pitches");
$pitchers = $stmt->fetchAll(PDO::FETCH_COLUMN);

header('Content-Type: application/json');
echo json_encode($pitchers);
?>
