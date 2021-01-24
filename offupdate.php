<?php

session_start();
require_once('dbconnect.php');

$code = $_SESSION['code'];

$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$bname = mysqli_real_escape_string($connection, $_POST['bname']);
$wc = mysqli_real_escape_string($connection, $_POST['wc']);
$city = mysqli_real_escape_string($connection, $_POST['city']);

$q = " UPDATE ASSESSING_OFFICER SET NAME='$fullname', EMAIL='$email', BUILD_NAME='$bname', WC='$wc', CITY='$city'  WHERE ID = '$code' " ;

if(mysqli_query($connection,$q))
  echo "<script> alert('Updation Successful!');window.location='officerupdate.php' </script>";

$connection->close();
?>
