<?php
session_start(); // Start the session to access lineup data

// Check if the pitcher is selected and get the lineup from session
$lineup = $_SESSION['lineup'] ?? null;
$teamName = $_SESSION['teamName'] ?? null;
$homeAway = $_SESSION['homeAway'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spray Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .chart-container { position: relative; width: 600px; height: 600px; margin: auto; }
        canvas { width: 100%; height: 100%; background: url('field.png') no-repeat center; background-size: cover; }
    </style>
</head>
<body>

    <h1>Spray Chart</h1>

    <?php if ($lineup): ?>
        <h2><?= htmlspecialchars($teamName) ?> (<?= htmlspecialchars($homeAway) ?> Team)</h2>
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Position</th>
            </tr>
            <?php foreach ($lineup as $num => $player): ?>
            <tr>
                <td><?= $num ?></td>
                <td><?= htmlspecialchars($player['name']) ?></td>
                <td><?= htmlspecialchars($player['position']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No lineup data available.</p>
    <?php endif; ?>

    <label for="pitcher">Select Pitcher:</label>
    <select id="pitcher" onchange="fetchData()">
        <option value="">-- Choose Pitcher --</option>
    </select>

    <div class="chart-container">
        <canvas id="sprayChart"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("get_pitchers.php")
                .then(response => response.json())
                .then(pitchers => {
                    const select = document.getElementById("pitcher");
                    pitchers.forEach(pitcher => {
                        let option = document.createElement("option");
                        option.value = pitcher;
                        option.textContent = pitcher;
                        select.appendChild(option);
                    });
                });

            // Initialize Chart
            window.sprayChart = new Chart(document.getElementById("sprayChart").getContext("2d"), {
                type: "scatter",
                data: { datasets: [{ label: "Ball in Play", data: [], backgroundColor: "red", pointRadius: 6 }] },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    scales: {
                        x: { min: 0, max: 400, title: { display: true, text: "Field Width (ft)" } },
                        y: { min: 0, max: 400, reverse: true, title: { display: true, text: "Distance from Home Plate (ft)" } }
                    }
                }
            });
        });

        function fetchData() {
            const pitcher = document.getElementById("pitcher").value;
            if (!pitcher) return;

            fetch(`view_data.php?pitcher=${pitcher}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        sprayChart.data.datasets[0].data = data.data;
                        sprayChart.update();
                    } else {
                        alert(data.message);
                    }
                });
        }
    </script>

</body>
</html>
<?php
include 'db_connect.php';
?>
