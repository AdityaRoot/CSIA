<?php
// Initialize the session and call config file to connect to database
session_start();
require_once "config.php";
// If the user is not logged in, redirect them to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Avoids URL abusing as GET method is used instead of POST, ensures that user is admin
if($_SESSION["acc_type"] !== "admin"){
  header("location: welcome.php");
}
// Assigns variables passed from previous webpage through GET method
$event_name = $_GET["event_name"];
$event_id = $_GET["id"];
$query = "DELETE FROM events WHERE event_id = $event_id"; // SQL query to delete the event in question
if(isset($_POST['Confirm'])){
  $stmt = mysqli_prepare($link,$query);
  if(mysqli_stmt_execute($stmt)){
    header("location: event_manage.php"); // Redirect user
  }
  mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
  <span style="display: inline;">
    <div class="page-header inline-flex">
        <h3><b>Are you sure you want to delete </b><?php echo "$event_name"?><b>?</b></h3>
        <form action='' method='POST'>
        <input type='submit' name='Confirm' class="btn btn-danger">
        </form>
        <a href="event_manage.php" class="btn btn-success">Cancel</a>
    </div>
  </span>
</body>
</html>
