<?php

// Establish MySQL connection
$servername = "localhost";
$username = "username";
$password = "password";
$database = "stock_database";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle API request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["ticker"])) {
    $ticker = $_GET["ticker"];

    // Prepare SQL statement to retrieve stock information based on ticker
    $sql = "SELECT * FROM stocks WHERE ticker = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ticker);

    // Execute SQL statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch data from the result set
        $row = $result->fetch_assoc();
        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        // Send error response if stock not found
        http_response_code(404);
        echo json_encode(array("message" => "Stock not found"));
    }
} else {
    // Send error response for invalid request
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request"));
}

// Close connection
$conn->close();

?>
