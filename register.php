<?php
// 1. Database Connection Details
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (no password)
$dbname = "user_db";

// 2. Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and Sanitize form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    // IMPORTANT: Hash the password before saving it
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // 4. Create the SQL query to insert data
    $sql = "INSERT INTO users (full_name, email, password) 
            VALUES ('$full_name', '$email', '$password')";

    // 5. Execute the query
    if ($conn->query($sql) === TRUE) {
        // Registration successful
        echo "<h2>✅ Account Created Successfully!</h2>";
        echo "<p>Your details have been saved to the database.</p>";
        // Redirect the user after successful registration
        echo '<script>window.location.href = "select_portal.html";</script>';
    } else {
        // Registration failed (e.g., email already exists)
        echo "<h2>❌ Error:</h2>" . $sql . "<br>" . $conn->error;
    }
} else {
    // If someone tries to access register.php directly
    echo "Access Denied.";
}

// 6. Close the connection
$conn->close();
?>
