<?php

session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$q1 = " SELECT ASSESS_YEAR,FLAG FROM income_tax WHERE PAN_NO = '$pan' ";
$res1 = mysqli_query($connection,$q1);
$val1 = mysqli_fetch_array($res1);
$flag = $val1['FLAG'];
$assess = $val1['ASSESS_YEAR'];

if($flag == NULL)
	echo "<script> alert('No payment entry available for assessment year ".$assess.".');window.location='userloginlinks.php' </script>";
else if($flag == 0)
	echo "<script> alert('Cannot delete payment entry when APPROVAL PENDING.');window.location='userloginlinks.php' </script>";
else if($flag == 2)
	echo "<script> alert('Cannot delete payment entry when it\'s APPROVED.');window.location='userloginlinks.php' </script>";
else
{
	$q2 = " DELETE FROM PAYMENT WHERE PAN_NO = '$pan' AND ASSESS_YEAR = '$assess' ";
	if(mysqli_query($connection,$q2))
		echo "<script> alert('Successfully deleted payment entry for assessment year ".$assess.".');window.location='userloginlinks.php' </script>";
}

?>