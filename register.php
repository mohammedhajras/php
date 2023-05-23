<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }
    
    .form-container {
      width: 380px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .form-group {
      margin-bottom: 20px;
      width: 340px;
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 5px;
      text-align: center;
    }
    
    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    
    button[type="submit"] {
      background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: block;
    margin: 18px auto 0 auto;
    }
    
    .login-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
      color: blue;
      text-decoration: none;
    }
    
    .login-link:hover {
      text-decoration: underline;
    }
    
    h1 {
      text-align: center;
    }
    
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f1f1f1;
      padding: 10px;
    }
    
    header a {
      text-decoration: none;
      color: black;
      margin-left: 10px;
    }
    
    header a:hover {
      text-decoration: underline;
    }

    .form-control {
      display: block;
    margin: auto;
    width: 100px;
    }
  </style>
</head>
<body>


  <header>
    <h1>Final Project</h1>
  </header>

  <div class="form-container">
    <h1>Register Page</h1>
    <form method="POST">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>
      
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      
      <div class="form-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
      </div>

      <div class="form-group">
              <label for="isAdmin">Admin or User</label>
              <select class="form-control" name="isAdmin" id="isAdmin">
                <option    value="2">Admin</option>
                <option    value="1">User</option>
              </select>
      
      <button type="submit">Submit</button>    </form>
    <a href="index.php" class="login-link">Login</a>
  </div>

  <?php
// Assuming you have a MySQL database set up with appropriate credentials
include('config.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session
session_start();

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];
    $role = $_POST['isAdmin'];

    // Check if the password matches the confirm password
    if ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
    } else {
        // Sanitize the input data to prevent SQL injection
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // Insert the data into the "users" table
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            // Retrieve the last inserted ID
            $id = mysqli_insert_id($conn);
        
            // Save the ID in a session variable
            $_SESSION["id"] = $id;
            $_SESSION["name"] = $name;
            // var_dump($_SESSION);
            echo "<p style='color:green; text-align:center'>Registration successful!</p>";
            if ($role == 1) {
                header('location:profile.php');
            } else {
                header('location:users.php');
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
  ?>

</body>
</html>
