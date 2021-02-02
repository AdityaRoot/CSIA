<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$event_name = $_GET["event_name"];
$event_id = $_GET["event_id"];
$user_id = $_GET["user_id"];
// Define SQL queries to add an element to the table as well as increment the number of participants by 1
$query = "INSERT INTO participations (event_id, user_id) VALUES ($event_id, $user_id)";
$query2 = "UPDATE events SET event_parts = event_parts + 1 WHERE event_id = $event_id";

if(isset($_POST['Confirm'])){
  header("location: events_registered.php");
  $stmt = mysqli_prepare($link,$query); // Prepare both statements (preperaton method prevents SQL injection)
  $stmt2 = mysqli_prepare($link,$query2);
  if(mysqli_stmt_execute($stmt)){ // Execute both queries
    if(mysqli_stmt_execute($stmt2)){
    header("location: events_registered.php"); // Redirect to page so user can confirm that they are registered
  }
  }
  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmt2);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm registtration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
  <span style="display: inline;">
    <div class="page-header inline-flex">
        <h3><b>Are you sure you want to register for </b><?php echo "$event_name"?><b>?</b></h3>
        <form action='' method='POST'>
        <input type='submit' name='Confirm' class="btn btn-success">
        </form>
        <a href="events_available.php" class="btn btn-danger">Cancel</a>
    </div>
  </span>
</body>
</html>
