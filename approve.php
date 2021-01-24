<?php

session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$assess = $_SESSION['assess'];

$q = " UPDATE PAYMENT SET STATUS = 'APPROVED' WHERE PAN_NO = '$pan' AND ASSESS_YEAR = '$assess' ";
if(mysqli_query($connection,$q))
{
	$store = " CALL SET_FLAG_2('$pan'); ";
	if(mysqli_query($connection,$store))
		echo "<script> alert('Approval Sent!');window.location='approvelist.php' </script>";
}

$connection->close();
?>
