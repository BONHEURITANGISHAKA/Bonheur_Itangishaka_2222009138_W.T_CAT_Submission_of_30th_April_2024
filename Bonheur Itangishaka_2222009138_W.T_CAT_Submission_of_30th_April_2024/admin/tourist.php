<?php
// Establish connection to the MySQL database
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize them
    if (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $name = $conn->real_escape_string($_POST['name']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

        // SQL query to update data in the tourist table
        $sql = "UPDATE tourist SET Name='$name', Phone='$phone', Email='$email', Password='$password', ConfirmPassword='$confirmPassword' WHERE ID='$id'";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $name = $conn->real_escape_string($_POST['name']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

        // SQL query to insert data into the tourist table
        $insert_sql = "INSERT INTO tourist (Name, Phone, Email, Password, ConfirmPassword) VALUES ('$name', '$phone', '$email', '$password', '$confirmPassword')";

        // Execute the insert query
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Record inserted successfully')</script>";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
}

// Check if delete button is clicked
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    // SQL query to delete record from tourist table
    $delete_sql = "DELETE FROM tourist WHERE ID = '$delete_id'";
    // Execute the delete query
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Record deleted successfully')</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve data from the tourist table
$sql = "SELECT * FROM tourist";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tourist Registration</title>
<link rel="stylesheet" href="styles.css">
</head>
<style>
    body{
         background-image: url('img.jpg');
    background-size: cover;
/*    background-position: center; /* Adjust this value as needed */*/
    background-repeat: no-repeat;
    }
    body, input[type="text"], input[type="email"], input[type="password"], button {
        font-family: Arial, sans-serif;
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
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

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    button:hover {
        background-color: #ffcc00;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: yellow;
    }

    footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 20px 0;
        width: 100%;
    }

    .footer-content {
        margin-top: 20px;
    }
</style>
<body>

<header>
    <nav>
        <div class="logo">
            <p>Tourist Connect</p>
        </div>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="tourist.php">Tourist</a></li>
            <li><a href="place.php">Place</a></li>
            <li><a href="activity.php">Activity</a></li>
            <li><a href="application.php">Application</a></li>
            <li class="dropdown">
                <a href="#">Settings</a>
                <div class="dropdown-content">
                    <a href="logout.php">Log out</a>
                </div>
            </li>
        </ul>
    </nav>
</header>
<main>
<div class="container">

    <h2>Tourist Form</h2>
    
    <form id="touristForm" method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
        <button type="submit" name="submit">Submit</button>
    </form>

</div>

<table>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Phone"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td><a href='?update=" . $row["ID"] . "'>Update</a> | <a href='tourist.php?delete=" . $row["ID"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>0 results</td></tr>";
    }
    ?>
</table>

<?php
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $update_sql = "SELECT * FROM tourist WHERE ID = '$update_id'";
    $update_result = $conn->query($update_sql);
    if ($update_result->num_rows > 0) {
        $update_row = $update_result->fetch_assoc();
?>
<div class="container">

    <h2>Update Tourist</h2>
    
    <form id="updateForm" method="post" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $update_row['ID']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required value="<?php echo $update_row['Name']; ?>">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required value="<?php echo $update_row['Phone']; ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?php echo $update_row['Email']; ?>">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required value="<?php echo $update_row['Password']; ?>">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required value="<?php echo $update_row['ConfirmPassword']; ?>">
        <button type="submit" name="update">Update</button>
    </form>
</div>
<?php 
    } else {
        echo "No record found!";
    }
}
?>

</main>
<footer>
    <div class="footer-content">
        <p>&copy; 2024 Tourist Connect. All rights reserved.</p>
    </div>
</footer>
</body>  
</html>
