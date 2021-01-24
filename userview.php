<?php
session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];

$q1 = " SELECT * FROM tax_payer WHERE PAN_NO = '$pan' ";
$res1 = mysqli_query($connection,$q1);
$val1 = mysqli_fetch_array($res1);
$pan = $val1['PAN_NO'];
$fname = $val1['FNAME'];
$lname = $val1['LNAME'];
$gen = $val1['GENDER'];
$dob = $val1['DOB'];
$addr = $val1['ADDRESS'];
$father = $val1['FATHER_NAME'];

$q2 = " SELECT * FROM income_tax WHERE PAN_NO = '$pan' ";
$res2 = mysqli_query($connection,$q2);
$val2 = mysqli_fetch_array($res2);
$res = $val2['RES'];
$income = $val2['INCOME'];
$assess = $val2['ASSESS_YEAR'];

$q3 = " SELECT b.* FROM bank_details b, tax_payer t WHERE t.PAN_NO = '$pan' AND t.ACC_NO = b.ACC_NO ";
$res3 = mysqli_query($connection,$q3);
$val3 = mysqli_fetch_array($res3);
$acc = $val3['ACC_NO'];
$bank = $val3['BANK_NAME'];
$baddr = $val3['ADDR'];
$ifsc = $val3['IFSC'];

$q4 = " SELECT a.* FROM assessing_officer a, tax_payer t WHERE t.PAN_NO = '$pan' AND t.ID = a.ID ";
$res4 = mysqli_query($connection,$q4);
$code = '-'; $area='-'; $aotype='-';$range='-';$aonum='-';$fullname='-';$email='-';$wc='-';$bname='-';$city='-';
if(mysqli_num_rows($res4) == 1) 
{
  $val4 = mysqli_fetch_array($res4);
  $code = $val4['ID'];
  $area = substr($code,0,3);
  $aotype = substr($code,3,1);
  $range = (strlen($code) == 8) ? substr($code,4,3) : substr($code,4,2);
  $aonum = (strlen($code) == 8) ? substr($code,7,1) : substr($code,6,1);
  $fullname = $val4['NAME'];
  $email = $val4['EMAIL'];
  $wc = $val4['WC'];
  $bname = $val4['BUILD_NAME'];
  $city = $val4['CITY'];
}

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
  <text class="navbar-brand">e-Tax User View</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <text class="nav-link"><?php echo $pan; ?></text>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="userloginlinks.php">BACK</a> 
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
      <td>NAME</td>
      <td><?php echo $fname.' '.$lname; ?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>PAN NUMBER</td>
      <td><?php echo $pan; ?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>ADDRESS</td>
      <td><?php echo $addr; ?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>GENDER</td>
      <td><?php if($gen == 'F') echo 'Female'; else echo 'Male'; ?></td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>DATE OF BIRTH</td>
      <td><?php echo $dob; ?></td>
    </tr>
    <tr>
      <th scope="row">6</th>
      <td>FATHER'S NAME</td>
      <td><?php echo $father; ?></td>
    </tr>
    <tr>
      <th scope="row">7</th>
      <td>STATUS</td>
      <td><?php echo $status; ?></td>
    </tr>
    <tr>
      <th scope="row">8</th>
      <td>RESIDENTIAL STATUS</td>
      <td><?php echo $res; ?></td>
    </tr>
    <tr>
      <th scope="row">9</th>
      <td>YEARLY INCOME</td>
      <td><?php echo $income; ?></td>
    </tr>
    <tr>
      <th scope="row">10</th>
      <td>ASSESSMENT YEAR</td>
      <td><?php echo $assess; ?></td>
    </tr>
    <tr>
      <th scope="row">11</th>
      <td>PREVIOUS YEAR</td>
      <td><?php echo $assess-1; ?></td>
    </tr>
  </tbody>
</table>

  <p><br><font size="5" style="padding-left: 10px"><b>BANK DETAILS</b></font></p>
  <table class="table table-striped table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="width: 175px">SERIAL NUMBER</th>
      <th scope="col" style="width: 350px">FIELDS</th>
      <th scope="col">VALUES</th>
    </tr>
  </thead>
    <tr>
      <th scope="row">1</th>
      <td>ACCOUNT NUMBER</td>
      <td><?php echo $acc ?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>BANK NAME</td>
      <td><?php echo $bank; ?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>BANK ADDRESS</td>
      <td><?php if($baddr == NULL) echo '-'; else echo $baddr; ?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>IFSC</td>
      <td><?php echo $ifsc; ?></td>
    </tr>
  </tbody>
</table>

<p><br><font size="5" style="padding-left: 10px"><b>JURISDICTION DETAILS <?php if(mysqli_num_rows($res4) == 0) echo "(AO not found)"; ?></b></font></p>
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
      <td>AO NAME</td>
      <td><?php echo $fullname; ?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>AREA CODE</td>
        <td><?php echo $area; ?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>AO TYPE</td>
        <td><?php echo $aotype; ?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>RANGE CODE</td>
        <td><?php echo $range; ?></td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>AO NUMBER</td>
        <td><?php echo $aonum; ?></td>
    </tr>
    <tr>
      <th scope="row">6</th>
      <td>EMAIL ID</td>
        <td><?php echo $email; ?></td>
    </tr>
    <tr>
      <th scope="row">7</th>
      <td>WARD/CIRCLE</td>
        <td><?php echo $wc; ?></td>
    </tr>
    <tr>
      <th scope="row">8</th>
      <td>BUILDING NAME</td>
        <td><?php echo $bname; ?></td>
    </tr>
    <tr>
      <th scope="row">9</th>
      <td>CITY</td>
       <td><?php echo $city; ?></td>
    </tr>
  </tbody>
</table>
</body>
</html>