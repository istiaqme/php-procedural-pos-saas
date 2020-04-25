<?php
$DBCON = mysqli_connect("localhost","root","","bonikbondhu_final");


// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  else {
  	mysqli_set_charset($DBCON,"utf8");
  }
?>