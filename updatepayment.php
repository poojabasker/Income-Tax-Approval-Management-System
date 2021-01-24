<?php

session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$assess = $_SESSION['assess'];

$tax = mysqli_real_escape_string($connection, $_POST['tax']);
$evc = mysqli_real_escape_string($connection, $_POST['evc']);
$dop = mysqli_real_escape_string($connection, $_POST['dop']);
$ip = mysqli_real_escape_string($connection, $_POST['ip']);

$q1 = " UPDATE PAYMENT SET TAX_PAID='$tax', DATE_PAID='$dop',EVC='$evc', IP_ADDR='$ip', STATUS='APPROVAL PENDING',PROBLEM=NULL WHERE PAN_NO = '$pan' AND ASSESS_YEAR ='$assess' " ;

if(mysqli_query($connection,$q1))
  echo "<script> alert('Updation Successful!');window.location='userloginlinks.php' </script>";

$connection->close();

?>