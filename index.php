<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitch Data Collection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f9;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .success-message {
            text-align: center;
            color: green;
            font-weight: bold;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Pitch Data Collection</h1>
    <form id="pitchForm">
        <label for="pitcher">Pitcher Name:</label>
        <input type="text" id="pitcher" name="pitcher">

        <label for="pitchType">Pitch Type:</label>
        <select id="pitchType" name="pitchType">
            <option value="">Select Pitch Type</option>
            <option value="FB">FB</option>
            <option value="SL">SL</option>
            <option value="CB">CB</option>
            <option value="CH">CH</option>
            <option value="CT">CT</option>
        </select>

        <label for="hitterHand">Hitter Hand:</label>
        <select id="hitterHand" name="hitterHand">
            <option value="">Select Hitter Hand</option>
            <option value="Right">Right</option>
            <option value="Left">Left</option>
        </select>

        <label for="result">Result:</label>
        <select id="result" name="result">
            <option value="">Select Result</option>
            <option value="Ball">Ball</option>
            <option value="Strike">Strike</option>
            <option value="Swing">Swing</option>
            <option value="Foul">Foul</option>
            <option value="In Play">In Play</option>
        </select>

        <label for="count">Count:</label>
        <select id="count" name="count">
            <option value="">Select Count</option>
            <option value="00">00</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="30">30</option>
            <option value="31">31</option>
            <option value="32">32</option>
        </select>

        <label for="VELO">VELO:</label>
        <input type="number" id="VELO" name="VELO">

        <label for="flight">Flight:</label>
        <select id="flight" name="flight">
            <option value="">Select Flight</option>
            <option value="Ground Ball">Ground Ball</option>
            <option value="Fly Ball">Fly Ball</option>
            <option value="Line Drive">Line Drive</option>
            <option value="Not In Play">Not In Play</option>
        </select>

        <label for="ballInPlay">Ball In Play Location:</label>
        <select id="ballInPlay" name="ballInPlay">
            <option value="">Select Location</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="Strike out">Strike out</option>
            <option value="Walk">Walk</option>
            <option value="HBP">HBP</option>
        </select>

        <label for="hardhit">Hard Hit:</label>
        <select id="hardhit" name="hardhit">
            <option value="">Select Hard Hit</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="out">OUT?:</label>
        <select id="out" name="out">
            <option value="">Select OUT</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <label for="hit">HIT?:</label>
        <select id="hit" name="hit">
            <option value="">None</option>
            <option value="SINGLE">SINGLE</option>
            <option value="DOUBLE">DOUBLE</option>
            <option value="TRIPLE">TRIPLE</option>
            <option value="HOME RUN">HOME RUN</option>
            <option value="ERROR">ERROR</option>
        </select>

     <button type="button" onclick="submitData()">Submit</button>
    </form>

    <p id="successMessage" class="success-message" style="display: none;">Data submitted successfully!</p>

    <a href="view_data.php">View Saved Data</a>

    <script>
        function submitData() {
            const form = document.getElementById('pitchForm');
            const formData = new FormData(form);

            // Debugging: Log form data before sending
            console.log("Submitting data...");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`); // Log each form field and its value
            }

            // Sending data to save_pitch.php
            fetch('save_pitch.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                // Debugging: Log the response from the server
                console.log("Server response:", data);

                // Display success message
                const successMessage = document.getElementById('successMessage');
                successMessage.style.display = 'block';

                // Reset the form after submission
                form.reset();

                // Hide success message after 3 seconds
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            })
            .catch(error => {
                // Debugging: Log errors if fetch fails
                console.error('Error submitting data:', error);
                alert('Error submitting data: ' + error);
            });
        }
    </script>
</body>
</html>
