<?php

//setting connection variables
$host='localhost:3307';
$username='root';
$password='root';
$database_name='itdb';

//connection to server and database
$connection=mysqli_connect($host, $username, $password, $database_name);

//checking the connection
if(mysqli_connect_errno())
{
	die("Connect failed : ". mysqli_connect_error());
	exit();
}

?>