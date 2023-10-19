<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo exec('whoami');

// Establish a database connection (modify these credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "wadrecipe";

$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["firstName"];
    $last_name = $_POST["lastName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"]; // Hash the password for security

    // Process the image upload
    $image = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];
    $image_path = "/opt/lampp/htdocs/test/images" . $image;

    if (move_uploaded_file($image_tmp, $image)) {
        // File uploaded successfully
        // Insert user data into the database
        $sql = "INSERT INTO users (firstName, lastName, email, username, password, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $username, $password, $image_path);
        
        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful!";
        } else {
            // Registration failed
            echo "Registration failed: " . $conn->error;
        }

        $stmt->close();
    } else {
        // File upload failed
        echo "Image upload failed.";
    }

    $conn->close();
}
?>
