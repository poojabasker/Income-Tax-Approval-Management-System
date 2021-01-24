<?php
session_start();
require_once('dbconnect.php');

$code = $_SESSION['code'];
$pan = $_GET['pan'];
$_SESSION['pan']=$pan;

$q1 = " SELECT * FROM tax_payer WHERE PAN_NO = '$pan' ";
$res1 = mysqli_query($connection,$q1);
$val1 = mysqli_fetch_array($res1);
$pan = $val1['PAN_NO'];
$fname = $val1['FNAME'];
$lname = $val1['LNAME'];
$addr = $val1['ADDRESS'];

$q2 = " SELECT * FROM INCOME_TAX WHERE PAN_NO = '$pan' ";
$res2 = mysqli_query($connection,$q2);
$val2 = mysqli_fetch_array($res2);
$res = $val2['RES'];
$income = $val2['INCOME'];
$assess = $val2['ASSESS_YEAR'];

$_SESSION['assess']=$assess;

$q3 = " SELECT b.* FROM bank_details b, tax_payer t WHERE t.PAN_NO = '$pan' AND t.ACC_NO = b.ACC_NO ";
$res3 = mysqli_query($connection,$q3);
$val3 = mysqli_fetch_array($res3);
$acc = $val3['ACC_NO'];
$ifsc = $val3['IFSC'];

$q4 = " SELECT * FROM PAYMENT WHERE PAN_NO = '$pan' AND ASSESS_YEAR = '$assess' ";
$res4 = mysqli_query($connection,$q4);
$val4 = mysqli_fetch_array($res4);
$tax = $val4['TAX_PAID'];
$dop = $val4['DATE_PAID'];
$evc = $val4['EVC'];
$ip = $val4['IP_ADDR'];

$c = substr($pan,3,1);
$status='';
switch($c)
{
  case 'P': $status='Individual'; break;
  case 'C': $status='Company'; break;
  case 'H': $status='Hindu Undivided Family(HUF)'; break;
  case 'A': $status='Association of Persons (AOP)'; break;
  case 'B': $status='Body of Individuals (BOI)'; break;
  case 'G': $status='Government Agency'; break;
  case 'J': $status='Artificial Judicial Person'; break;
  case 'L': $status='Local Authority'; break;
  case 'F': $status='Firm/Limited Liability Partnership'; break;
  case 'T': $status='Trust'; break;
}

if($res == 'ROR')
  $res = 'Resident';
else if($res == 'NR')
  $res = 'Non Resident';
else
  $res = 'Resient but Not Ordinarily Resident';

$connection->close();
?>

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
  <text class="navbar-brand">e-Tax Officer Approval User</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
       <li class="nav-item">
        <text class="nav-link"><?php echo $code; ?></text> 
      </li>
      <li class="nav-item">
        <a class="nav-link" href="approvelist.php">BACK</a> 
      </li>
    </ul>
  </div>
</nav>
</section>

<p><br><font size="5" style="padding-left: 10px"><b>USER DETAILS</b></font></p>
<table class="table table-striped table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="width: 175px">SERIAL NUMBER</th>
      <th scope="col" style="width: 350px">FIELDS</th>
      <th scope="col">VALUES</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>PAN NUMBER</td>
      <td><?php echo $pan; ?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>NAME</td>
      <td><?php echo $fname.' '.$lname; ?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>ADDRESS</td>
      <td><?php echo $addr; ?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>STATUS</td>
      <td><?php echo $status; ?></td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>RESIDENTIAL STATUS</td>
      <td><?php echo $res; ?></td>
    </tr>
    <tr>
      <th scope="row">6</th>
      <td>YEARLY INCOME</td>
      <td><?php echo $income; ?></td>
    </tr>
    <tr>
      <th scope="row">7</th>
      <td>ASSESSMENT YEAR</td>
      <td><?php echo $assess; ?></td>
    </tr>
    <tr>
      <th scope="row">8</th>
      <td>PREVIOUS YEAR</td>
      <td><?php echo $assess-1; ?></td>
    </tr>
    <tr>
      <th scope="row">9</th>
      <td>ACCOUNT NUMBER</td>
      <td><?php echo $acc; ?></td>
    </tr>
    <tr>
      <th scope="row">10</th>
      <td>IFSC</td>
      <td><?php echo $ifsc; ?></td>
    </tr>
    <tr>
      <th scope="row">11</th>
      <td>TAX PAID</td>
        <td><?php echo $tax; ?></td>
    </tr>
    <tr>
      <th scope="row">12</th>
      <td>ELECTRONIC VERIFICATION CODE</td>
        <td><?php echo $evc; ?></td>
    </tr>
    <tr>
      <th scope="row">13</th>
      <td>IP_ADDRESS</td>
        <td><?php echo $ip; ?></td>
    </tr>
  </tbody>
</table>

<a href="disapprove.php">
<button type="button" id="showPrompt" style="margin-left: 100px; margin-top: 20px; margin-bottom: 20px; width: 500px" class="btn btn-danger">DISAPPROVE</button>
</a>

<a href="approve.php">
<button type="button" style="margin-left: 50px; margin-top: 20px; margin-bottom: 20px; width: 500px" class="btn btn-success">APPROVE</button>

</body>
</html>