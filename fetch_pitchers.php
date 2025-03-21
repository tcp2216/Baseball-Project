<?php
header('Content-Type: application/json');

// URL of the roster page
$url = "https://arkansastechsports.com/sports/baseball/roster?view=1";

// Fetch the HTML content
$html = file_get_contents($url);

// Check if the request succeeded
if ($html === false) {
    echo json_encode(["error" => "Failed to fetch roster data."]);
    exit;
}

// Load the HTML into a DOM parser
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Suppress warnings from invalid HTML
$dom->loadHTML($html);
libxml_clear_errors();

// Find all player names in the roster
$xpath = new DOMXPath($dom);
$names = $xpath->query('//div[@class="sidearm-roster-player-name"]/a');

$players = [];
foreach ($names as $name) {
    $players[] = trim($name->nodeValue);
}

// Return the names as JSON
echo json_encode($players);
?>
