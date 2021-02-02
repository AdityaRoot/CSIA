<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
    <div class="page-header">
        <h1>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
        <h5><br> Your account type is: <b><?php echo htmlspecialchars($_SESSION["acc_type"])?></b><br> Your account id is: <b><?php echo htmlspecialchars($_SESSION["id"])?></b><br> Spoken language is:<b> <?php echo htmlspecialchars($_SESSION["lang"])?></b></h5>
    </div>
    <p>
      <div class="btn-group" role="group">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Events
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="events_registered.php">View registered events</a>
            <a class="dropdown-item" href="events_available.php">View eligible events</a>
          </div>
        </div>
        <?php if($_SESSION["acc_type"] == "admin") : ?>
          <a href="event_manage.php" class="btn btn-primary">Manage events</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-primary">Sign Out of Your Account</a>
      </div>
    </p>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>
