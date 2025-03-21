<?php
session_start(); // Start the session to store lineup data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teamName = $_POST['teamName'];
    $homeAway = $_POST['homeAway'];
    $lineup = $_POST['lineup'];

    // Store data in session
    $_SESSION['teamName'] = $teamName;
    $_SESSION['homeAway'] = $homeAway;
    $_SESSION['lineup'] = $lineup;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baseball Lineup</title>
    <style>
        /* Your styling remains the same */
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Enter Baseball Lineup</h2>
        <form method="post">
            <label>Team Name: <input type="text" name="teamName" required></label><br><br>
            <label>Home or Away:
                <select name="homeAway">
                    <option value="Home">Home</option>
                    <option value="Away">Away</option>
                </select>
            </label><br><br>
            <table>
                <tr>
                    <th>Number</th>
                    <th>Name</th>
                    <th>Position</th>
                </tr>
                <?php for ($i = 1; $i <= 9; $i++): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><input type="text" name="lineup[<?= $i ?>][name]" required></td>
                    <td><input type="text" name="lineup[<?= $i ?>][position]" required></td>
                </tr>
                <?php endfor; ?>
            </table>
            <br>
            <button type="submit">Submit Lineup</button>
        </form>
    </div>

    <?php if (isset($_SESSION['teamName'])): ?>
        <h2><?= htmlspecialchars($_SESSION['teamName']) ?> (<?= htmlspecialchars($_SESSION['homeAway']) ?> Team)</h2>
        <table>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Position</th>
            </tr>
            <?php foreach ($_SESSION['lineup'] as $num => $player): ?>
            <tr>
                <td><?= $num ?></td>
                <td><?= htmlspecialchars($player['name']) ?></td>
                <td><?= htmlspecialchars($player['position']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
