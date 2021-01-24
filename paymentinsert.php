<?php

session_start();
require_once('dbconnect.php');

$assess = (int) $_SESSION['assess'];
$pan = $_SESSION['pan'];

$tax = mysqli_real_escape_string($connection, $_POST['tax']);
$evc = mysqli_real_escape_string($connection, $_POST['evc']);
$dop = mysqli_real_escape_string($connection, $_POST['dop']);
$ip = mysqli_real_escape_string($connection, $_POST['ip']);

$q1 = " SELECT PAN_NO FROM PAYMENT WHERE PAN_NO = ? AND ASSESS_YEAR = ? LIMIT 1 ";
$q2 = " INSERT INTO PAYMENT (PAN_NO,TAX_PAID,DATE_PAID,EVC,IP_ADDR,ASSESS_YEAR) VALUES (?,?,?,?,?,?) ";

$st1 = $connection->prepare($q1);
$st1->bind_param("si",$pan,$assess);
$st1->execute();
$st1->store_result();

if($st1->num_rows == 0)
{
	$st1->close();

	$st1 = $connection->prepare($q2);
	$st1->bind_param("sssssi", $pan, $tax, $dop, $evc, $ip, $assess);
	$st1->execute();

	echo "<script> alert('Payment Details sent to Assessing Officer for approval!');window.location='userloginlinks.php' </script>"; 
}

else
	echo "<script> alert('Entry exists for the assessment year. To change entry, go to edit Payment Details.');window.location = window.history.back() </script>";

$st1->close();
$connection->close();

?>