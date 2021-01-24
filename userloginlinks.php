<?php
session_start();
if(!$_SESSION['pan'])
{
    header('Location: user.php');
    return;
}

require_once('dbconnect.php');
$pan = $_SESSION['pan'];

$q1 = " SELECT FNAME FROM tax_payer WHERE PAN_NO = '$pan' ";
$res1 = mysqli_query($connection,$q1);
$res1 = mysqli_fetch_array($res1)['FNAME'];

$q2 = " SELECT ASSESS_YEAR FROM INCOME_TAX WHERE PAN_NO = '$pan' ";
$res2 = mysqli_query($connection,$q2);
$res2 = mysqli_fetch_array($res2)['ASSESS_YEAR'];

$_SESSION['assess'] = $res2;
$connection->close();
?>

<!DOCTYPE html>
<html>

<head>
<title>e-Tax</title>    
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
</head>

<body>

 <!---Navbar---> 
<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax User</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <text class="nav-link" href="userloginlinks.php"><?php echo $pan; ?></text>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">LOGOUT</a> 
      </li>
    </ul>
  </div>
</nav>
</section>
<div style="text-align: center; padding-top:50px">
  <p><font size="7"><b>Welcome, <?php echo $res1; ?>!</b></font></p>
  <p><font size="4" color="red"><b>CURRENT ASSESSMENT YEAR : <?php echo $res2; ?></b></font></p>
</div>
<table class="table table-light table-hover" style="text-align: center; height: 250px; font-size: 20px; margin-top: 20px">
  <tbody>
    <tr>
      <td><a href="userview.php"><u>Click here to view Personal Details</u></a></td>
    </tr>
    <tr>
      <td><a href="userupdate.php"><u>Click here to edit Personal Details</u></a></td>
    </tr>
    <tr>
      <td><div class="dropdown show">
      <a class=" dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><u>Click here to enter Payment Details</u></a>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
      <a class="dropdown-item" href="newpayment.php">Enter new Payment Details</a>
      <a class="dropdown-item" href="editpayment.php">Edit Payment Details</a>
      <a class="dropdown-item" href="viewpayment.php">View Payment Details</a>
      <a class="dropdown-item" href="deletepayment.php">Delete Payment Details</a>
  </div>
    </div>
    </td>
    </tr>
</tbody>
</table>

</body>
</html>
