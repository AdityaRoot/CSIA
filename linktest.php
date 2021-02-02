<?php

  $conn = mysqli_connect('localhost', 'root','','csia');
  echo 'File valid';
  if(!$conn){
    echo 'DB Connection error: ' . mysqli_connect_error();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>

</body>
</html>
