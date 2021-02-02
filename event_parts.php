<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Avoids URL abusing as GET method is used instead of POST, ensures that user is admin
if($_SESSION["acc_type"] !== "admin"){
  header("location: welcome.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Participants</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ margin-right: 100px;}
        td {
          height: 25px;

        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Attendees for, <b><?php echo htmlspecialchars($_GET["event_name"]); ?></b>.</h1>
        <h5><br> Your account type is: <b><?php echo htmlspecialchars($_SESSION["acc_type"])?></b><br> Your account id is: <b><?php echo htmlspecialchars($_SESSION["id"])?></b></h5>
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
    <?php
    $event_name = $_GET["event_name"];
    $event_id = $_GET["id"];
    // SQL query to collect all the entries in users that are cross referenced through the participants table by the event id passed through GET
$result = mysqli_query($link,"SELECT * FROM `users` WHERE `id` IN (SELECT `user_id` FROM `participations` WHERE `event_id` = $event_id)");

echo "<table class=\"table table-hover table-bordered mx-auto\" >
<thead class='thead-dark'>
<tr>
<th scope=\"col\">Attendee user id</th>
<th scope=\"col\">Attendee username</th>
<th scope=\"col\">Attendee language</th>
<th scope=\"col\">Attendee phone number</th>
</tr>
</thead>
<tbody>";


while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td style=\"text-align: center;\">" . $row['id'] . "</td>";
echo "<td style=\"text-align: center;\">" . $row['username'] . "</td>";
echo "<td style=\"text-align: center;\">" . $row['lang'] . "</td>";
echo "<td style=\"text-align: center;\">" . $row['phone_number'] . "</td>";
echo "</tr>";
}
echo "</tbody>
</table>";

mysqli_close($link);
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>
