<?php
echo "this is a test";

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo exec('whoami');

// Establish a database connection (modify these credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "wadrecipe";

$conn = new mysqli("localhost", "root", "", "wadrecipe");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"]; // Hash the password for security

    // Process the image upload
    // File uploaded successfully
    // Insert user data into the database
    $sql = "SELECT * from users where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if ($stmt_result->num_rows > 0) {
        // Registration successful
        $data = $stmt_result->fetch_assoc();
        if ($data['password'] === $password) {
            echo "<h2>Login Success</h2>";
        } else {
            echo "<h2>Invalid email or password</h2>";
        }
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "<h2>Invalid email or password</h2>";
    }

    $stmt->close();
} else {
    // File upload failed
    echo "Image upload failed.";
}

$conn->close();
?>
