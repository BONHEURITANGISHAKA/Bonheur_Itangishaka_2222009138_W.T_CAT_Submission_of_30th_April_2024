<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username and password are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Your database connection code
        $servername = "localhost"; // Change this to your MySQL server hostname if different
        $username = "root"; // Change this to your MySQL username
        $password = ""; // Change this to your MySQL password
        $database = "touristconnect"; // Change this to the name of your database

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Collect form data and sanitize them
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        // SQL query to retrieve user from database
        $sql = "SELECT * FROM User WHERE username='$username' AND password='$password'";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Login successful
            $_SESSION['username'] = $username;
            header("Location: admin/index.html"); // Redirect to admin page
            exit();
        } else {
            // Login failed
            $error = "Invalid username or password";
        }

        // Close the database connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: darkgray;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 290px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
}

input {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: orange;
    color: #fff;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

</style>
<title>User Login</title>
</head>
<style>
    body{
         background-image: url('imgs.jpg');
    background-size: cover;
/*    background-position: center; /* Adjust this value as needed */*/
    background-repeat: no-repeat;
    }
</style>
<body>

<div class="container">
    <h2>Login</h2>
    <form id="loginForm" method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="submit">Login</button><a href="index.html"> back to home page</a>
    </form>
</div>


</body>
</html>
