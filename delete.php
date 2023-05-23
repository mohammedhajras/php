<?php 
    include('config.php');
    $user_id = $_GET['id'];
    mysqli_query($conn ,"DELETE FROM users WHERE id=$user_id");
    header('location:users.php');
?>