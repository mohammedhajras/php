<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        
        h2 {
            color: #333;
    font-size: 24px;
    margin-bottom: 30px;
    text-align: center;
        }
        
        a {
      padding: 6px 12px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
        margin: 0 10px;      
        text-decoration: none;
        display: block;
        text-align: center;
        
        }

        header {
        display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: white;
    }

    .logout {
        background-color: #4CAF50;
        color: white;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }

    .info{
        display: flex;
        align-items: center;
    }
            </style>
</head>
<body>
<header>
    <h2>Final Project</h2>
    <div class="info">
        <form method="post">
        <input class="logout" type="submit" name="Logout" value="Logout">
        </form>
    </div>

    </header>
    <?php
    session_start();
    // Database connection details
    include("config.php");

    $id =$_SESSION['id'];
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve data from the "users" table
    $sql = "SELECT * FROM users Where id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the email and password in an H2 heading
        while ($row = $result->fetch_assoc()) {
            echo "<h2>Name: " . $row["name"] . "</h2>";
            echo "<h2>Email: " . $row["email"] . "</h2>";
            echo "<h2>Password: " . $row["password"] . "</h2>";
            echo "<a href='updateUserFromprofile.php?id=$row[id]'>Edit</a>";
        }

        // Add an edit link
    } else {
        echo "No results found.";
    }

    // Close the database connection
    $conn->close();
    ?>



    <?php
        if(isset($_POST['Logout'])){
            session_unset();
            session_destroy();
            header('location:register.php');
        }
        ?>



</body>
</html>
