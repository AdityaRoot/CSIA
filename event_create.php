<?php
require_once "config.php";
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["acc_type"] !== "admin"){
  header("location: welcome.php");
}
// Define all variables
$event_name = $event_lang = $event_date = $event_desc = "";
$event_name_err = $event_date_err = $event_desc_err = "";
$event_max = 0;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Confirm eventname is less than 100 characters and exists
    if(empty(trim($_POST["eventname"]))){
        $event_name_err = "Please enter an event name.";
    }  elseif(strlen(trim($_POST["eventname"])) > 100){
        $event_desc_err = "Event description must be less than 100 characters.";
    } else{
        $event_name = trim($_POST["eventname"]);
    }

    // Confirm that date is inputted correctly
    if(empty(trim($_POST["eventdate"]))){
        $event_date_err = "Please insert a date in the YYYYMMDD format.";
    } else{
        $event_date = trim($_POST["eventdate"]);
    }

    // Confirm that event description is less than 60000 characters
    if(empty(trim($_POST["eventdesc"]))){
        $event_desc_err = "Please enter an event description.";
    } elseif(strlen(trim($_POST["eventdesc"])) > 60000){
        $event_desc_err = "Event description must be less than 60000 characters.";
    } else{
        $event_desc = trim($_POST["eventdesc"]);
    }

    // Check input errors before inserting in database
    if(empty($event_name_err) && empty($event_date_err) && empty($event_desc_err)){
      $event_lang = $_POST["eventlang"];
      $event_max = $_POST["eventmax"];
        // Prepare an insert statement
        $sql = "INSERT INTO events (event_name, event_date, event_desc, event_lang, event_max) VALUES (?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $event_name, $event_date, $event_desc, $event_lang, $event_max);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to event management page
                header("location: event_manage.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Creation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{width: 850px; margin-left:auto; margin-right: auto;}
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Event creation page for, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
        <h5><br> Your account type is: <b><?php echo htmlspecialchars($_SESSION["acc_type"])?></b><br> Your account id is: <b><?php echo htmlspecialchars($_SESSION["id"])?></b><br> Spoken language is:<b> <?php echo htmlspecialchars($_SESSION["lang"])?></b></h5>
    </div>
    <p>
      <div class="btn-group" role="group">
          <a href="event_manage.php" class="btn btn-primary">Cancel Event Creation</a>
      </div>
    </p>
    <div class="wrapper">
    <h2>Event Creation Form</h2>
    <p>Please fill this form to create an event.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($event_name_err)) ? 'has-error' : ''; ?>">
            <label>Event Name</label>
            <input type="text" name="eventname" class="form-control" value="<?php echo $event_name; ?>">
            <span class="help-block"><?php echo $event_name_err; ?></span> <!-- Echoes the php error in a box underneath the input -->
        </div>
        <div class="form-group <?php echo (!empty($event_date_err)) ? 'has-error' : ''; ?>">
            <label>Event date:</label>
            <input type="date" name="eventdate" class="form-control" placeholder="YYYYMMDD" value="<?php echo $event_date; ?>"> <!-- Placeholder tag shows 'YYYYMMDD' in greyed out text on the field -->
            <span class="help-block"><?php echo $event_date_err; ?></span>
        </div>
        <div class="form-group">
            <label>Maximum number of attendees:</label>
            <input type="number" name="eventmax" class="form-control" placeholder="Insert number here" value="<?php echo $event_max; ?>">
        </div>
        <div class="form-group <?php echo (!empty($event_desc_err)) ? 'has-error' : ''; ?>">
            <label>Event description</label>
            <textarea type="eventdesc" name="eventdesc" class="form-control" rows="3" value="<?php echo $event_desc; ?>"></textarea>
            <span class="help-block"><?php echo $event_desc_err; ?></span>
        </div>
        <div class="form group">
          <label>Event language:</label>
          <select class="form-control" name="eventlang">
            <option value="cantonese">Cantonese</option>
            <option value="english">English</option>
            <option value="both">Both</option>
          </select>
        </div><br>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
    </form>
</div>
</body>
</html>
