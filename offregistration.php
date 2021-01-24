<?php

session_start();
require_once('dbconnect.php');

$code = mysqli_real_escape_string($connection, $_POST['code']);
$fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$pwd = mysqli_real_escape_string($connection, $_POST['pwd']);
$bname = mysqli_real_escape_string($connection, $_POST['bname']);
$wc = mysqli_real_escape_string($connection, $_POST['wc']);
$city = mysqli_real_escape_string($connection, $_POST['city']);

$q1 = " SELECT ID FROM ASSESSING_OFFICER WHERE ID = ? LIMIT 1 ";
$q2 = " INSERT INTO ASSESSING_OFFICER (ID,AO_PWD,NAME,EMAIL,BUILD_NAME,WC,CITY) VALUES (?,?,?,?,?,?,?) ";

$st1 = $connection->prepare($q1);
$st1->bind_param("s",$code);
$st1->execute();
$st1->store_result();

if($st1->num_rows == 0)
{
	$st1->close();

	$st1 = $connection->prepare($q2);
	$st1->bind_param("sssssss", $code, $pwd, $fullname, $email, $bname, $wc, $city);
	$st1->execute();

	$_SESSION['code'] = $code;

	echo "<script> alert('Registration Successful!');window.location='officerloginlinks.php' </script>"; 
}

else
	echo "<script> alert('AO Code already exists.');window.location = window.history.back() </script>";

$st1->close();
$connection->close();

?>