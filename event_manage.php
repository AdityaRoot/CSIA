<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Check if the user is an admin, if not then redirect him to the welcome page
if($_SESSION["acc_type"] !== "admin"){
  header("location: welcome.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Management</title>
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
        <h1>Event management page for, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
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
          <a href="event_create.php" class="btn btn-success">Create an event</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-primary">Sign Out of Your Account</a>
      </div>
    </p>
    <?php
// SQL query that collects all events sorted by event date
$result = mysqli_query($link,"SELECT * FROM events ORDER BY event_date");

echo "<table class=\"table table-hover table-bordered mx-auto\" >
<thead class='thead-dark'>
<tr>
<th scope=\"col\">Event date</th>
<th scope=\"col\">Event name</th>
<th scope=\"col\">Event description</th>
<th scope=\"col\">Event participants</th>
<th scope=\"col\">Event language</th>
<th scope=\"col\">Event Deletion</th>
<th scope=\"col\">Event Participants</th>
</tr>
</thead>
<tbody>";

// While loop to insert each event into it's own table row
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td style=\"text-align: center;\">" . $row['event_date'] . "</td>";
echo "<td style=\"text-align: center;\">" . $row['event_name'] . "</td>";
echo "<td>" . nl2br($row['event_desc']) . "</td>";
echo "<td style=\"text-align: center;\">" . $row['event_parts'] . "/" . $row['event_max'] . "</td>";
echo "<td style=\"text-align: center;\">" . $row['event_lang'] . "</td>";
echo "<td style=\"text-align: center;\"><a href=\"confirm_delete.php?id=" . $row['event_id'] . "&event_name=" . $row['event_name'] . "\" class=\"btn btn-danger\">Delete event</a></td>";
echo "<td style=\"text-align: center;\"><a href=\"event_parts.php?id=" . $row['event_id'] . "&event_name=" . $row['event_name'] . "\" class=\"btn btn-warning\">Event Participants</a></td>";
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
