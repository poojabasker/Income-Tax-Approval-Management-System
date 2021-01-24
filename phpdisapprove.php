<?php

session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$assess = $_SESSION['assess'];
$prob = mysqli_real_escape_string($connection, $_GET['prob']);

$q = " UPDATE PAYMENT SET STATUS = 'DISAPPROVED', PROBLEM = '$prob' WHERE PAN_NO = '$pan' AND ASSESS_YEAR = '$assess' ";

if(mysqli_query($connection,$q))
{
	$store = " CALL SET_FLAG_1('$pan'); ";
	if(mysqli_query($connection,$store))
		echo "<script> alert('Acknoledgement Sent!');window.location='approvelist.php' </script>";
}

$connection->close();
?>
