<?php
// Generate a connection to the database
$link = mysqli_connect('localhost', 'root','','csia');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
