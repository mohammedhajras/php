<?php
session_start();

// Assuming you have a MySQL database set up with appropriate credentials
include('config.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
    
    .container {
      width: 800px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .container h2 {
      text-align: center;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    
    th {
      background-color: #f2f2f2;
    }
    
    .btn {
      padding: 6px 12px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .btn.edit {
        background-color: #2196F3;
    margin: 0 10px;      
    text-decoration: none;

    }
    
    .btn.delete {
      background-color: #F44336;
      text-decoration: none;
    }

    header {
        display: flex;
    justify-content: space-between;
    align-items: center;
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
  <div class="container">
    <header>
    <h2>Final Project</h2>
    <div class="info">
        <p class="name" style="font-weight: bold;    margin: 0 10px;"><?php echo $_SESSION['name']; ?></p>
        <form method="post">
        <input class="logout" type="submit" name="Logout" value="Logout">
        </form>
    </div>

    </header>

    <table>
      <tr>
        <th>Email</th>
        <th>Name</th>
        <th>Actions</th>
      </tr>

      <?php
      // Retrieve data from the "users" table
      $sql = "SELECT id, email, name FROM users";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          // Output data of each row
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row['email'] . "</td>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>";
              echo "<a href='update.php?id=$row[id]' class='btn edit'>Edit</a>";
              echo "<a href='delete.php?id=$row[id]' class='btn delete'>Delete</a>";
              echo "</td>";
              echo "</tr>";




          }
      } else {
          echo "<tr><td colspan='3'>No records found</td></tr>";
      }

      // Close the result set
      mysqli_free_result($result);

      // Close the database connection
      mysqli_close($conn);
      ?>

      <?php
      if(isset($_POST['Logout'])){
        session_unset();
        session_destroy();
        header('location:register.php');
      }
      ?>
      
    </table>
  </div>
</body>
</html>
