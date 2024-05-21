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
        $description = $conn->real_escape_string($_POST['description']);
        $location = $conn->real_escape_string($_POST['location']);
        $price = $conn->real_escape_string($_POST['price']);
        $date = $conn->real_escape_string($_POST['date']);

        // SQL query to update data in the place table
        $sql = "UPDATE place SET Name='$name', Description='$description', Location='$location', Price='$price', Date='$date' WHERE ID='$id'";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record updated successfully')</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $location = $conn->real_escape_string($_POST['location']);
        $price = $conn->real_escape_string($_POST['price']);
        $date = $conn->real_escape_string($_POST['date']);

        // SQL query to insert data into the place table
        $insert_sql = "INSERT INTO place (Name, Description, Location, Price, Date) VALUES ('$name', '$description', '$location', '$price', '$date')";

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
    // SQL query to delete record from place table
    $delete_sql = "DELETE FROM place WHERE ID = '$delete_id'";
    // Execute the delete query
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Record deleted successfully')</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve data from the place table
$sql = "SELECT * FROM place";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Place Registration</title>
<link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        background-image: url('img.jpg');
        background-size: cover;
        background-repeat: no-repeat;
    }

    body,
    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea,
    button {
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
        margin-bottom: 20px;
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
    input[type="password"],
    textarea {
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: yellow;
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

    <h2>Place Form</h2>
    
    <form id="placeForm" method="post" action="">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <button type="submit" name="submit">Submit</button>
    </form>

</div>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Location</th>
        <th>Price</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Description"] . "</td>";
            echo "<td>" . $row["Location"] . "</td>";
            echo "<td>" . $row["Price"] . "</td>";
            echo "<td>" . $row["Date"] . "</td>";
            echo "<td><a href='?update=" . $row["ID"] . "'>Update</a> | <a href='place.php?delete=" . $row["ID"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>0 results</td></tr>";
    }
    ?>
</table>

<?php
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $update_sql = "SELECT * FROM place WHERE ID = '$update_id'";
    $update_result = $conn->query($update_sql);
    if ($update_result->num_rows > 0) {
        $update_row = $update_result->fetch_assoc();
?>
<div class="container">

    <h2>Update Place</h2>
    
    <form id="updateForm" method="post" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $update_row['ID']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required value="<?php echo $update_row['Name']; ?>">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $update_row['Description']; ?></textarea>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required value="<?php echo $update_row['Location']; ?>">
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required value="<?php echo $update_row['Price']; ?>">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required value="<?php echo $update_row['Date']; ?>">
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
</body>  
</html>
