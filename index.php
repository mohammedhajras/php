
<?php
session_start();

// Assuming you have a MySQL database set up with appropriate credentials
include('config.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];


    // Sanitize the input data to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Query the database to check if the email and password combination exists
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Login successful, store user data in session
        $row = mysqli_fetch_assoc($result);
        $_SESSION["id"] = $row["id"];
        $_SESSION["name"] = $row["name"];

        // Redirect to users.php
        if ($row['role'] ==1){
          header('location:profile.php');
        }else{
          header('location:users.php');
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

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
    }
    
    .form-group label {
      display: block;
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 5px;
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
  </style></head>
<body>
    <div class="form-container">
        <h1>Login Page</h1>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Submit</button>
        </form>

        <a href="register.php" class="login-link">Register</a>

        <?php
        if (isset($error)) {
            echo "<p style='color:red; text-align:center'>$error</p>";
        }
        ?>
    </div>
</body>
</html>
