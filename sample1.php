<?php
// Database connection settings
$servername = "localhost"; // Database server
$username = "root";        // MySQL username
$password = "";            // MySQL password
$dbname = "hacktech";      // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $countryCode = $_POST['countryCode'];
    $phoneNumber = $_POST['phoneNumber'];

    // Prepare SQL query to insert data
    $sql = "INSERT INTO orders (country_code) VALUES ('$countryCode')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Phone number saved successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Number Form</title>
</head>
<body>
    <h1>Submit Your Phone Number</h1>
    <form action="sample1.php" method="POST">
        <label for="countryCode">Country Code:</label>
        <select id="countryCode" class="box" name="countryCode" required>
            <option value="+1">United States (+1)</option>
            <option value="+44">United Kingdom (+44)</option>
            <option value="+91">India (+91)</option>
            <!-- Add more country codes as needed -->
        </select>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
