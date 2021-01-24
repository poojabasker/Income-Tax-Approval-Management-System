<?php
session_start();
require_once('dbconnect.php');

$pan1 = $_SESSION['pan'];

$pan='-'; $income='-'; $tax='-'; $assess='-'; $evc='-'; $ip='-'; $app='-'; $status='-'; $prob='-'; $num=-1;

if(isset($_POST['sbutton']) && strlen($_POST['search'])==4)
{
	$assess1 = $_POST['search'];

	$q1 = " SELECT * FROM PAYMENT WHERE PAN_NO = '$pan1' AND ASSESS_YEAR='$assess1' ";
	$res1 = mysqli_query($connection,$q1);
	$num = mysqli_num_rows($res1);
	if($num == 1)
	{
		$pan = $_SESSION['pan'];
		$assess = $_POST['search'];
		$val1 = mysqli_fetch_array($res1);
		$tax = $val1['TAX_PAID'];
		$dop = $val1['DATE_PAID'];
		$evc = $val1['EVC'];
		$ip = $val1['IP_ADDR'];
		$status = $val1['STATUS'];
		$prob = $val1['PROBLEM'];

		$q2 = " SELECT INCOME,FLAG FROM INCOME_TAX WHERE PAN_NO = '$pan' ";
		$res2 = mysqli_query($connection,$q2);
		$val2 = mysqli_fetch_array($res2);
		$income = $val2['INCOME'];
		$flag = $val2['FLAG'];
	}
}

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

<body onload="document.form1.first.focus();">

<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax User Payment</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <text class="nav-link"><?php echo $pan1; ?></text>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="userloginlinks.php">BACK</a>
      </li>
    </ul>
  </div>
</nav>
</section>

<div class="login">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="form1">
	<input type="text" id="search" name="search" placeholder="Enter assessment year..." tabindex="-1">
	 <input type="submit" name="sbutton" value="Search" class="btn btn-secondary" tabindex="-1">
</form>
</div>

<p><br><font size="5" style="padding-left: 10px"><b>PAYMENT DETAILS <?php if($num == 0) echo "(No payment entry found for given assessment year.)"; ?></b></font></p>
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
      <td>PAN_NO</td>
      <td><?php echo $pan; ?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>INCOME</td>
        <td><?php echo $income; ?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>TAX PAID</td>
        <td><?php echo $tax; ?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>ASSESSMENT YEAR</td>
        <td><?php echo $assess; ?></td>
    </tr>
    <tr>
    <tr>
      <th scope="row">5</th>
      <td>ELECTRONIC VERIFICATION CODE</td>
        <td><?php echo $evc; ?></td>
    </tr>
    <tr>
      <th scope="row">6</th>
      <td>IP_ADDRESS</td>
        <td><?php echo $ip; ?></td>
    </tr>
    <tr>
      <th scope="row">7</th>
      <td>APPROVAL STATUS</td>
        <td class="<?php if($status == 'APPROVAL PENDING') echo "table-warning"; else if($status == 'DISAPPROVED') echo "table-danger"; else if($status == 'APPROVED') echo "table-success"; ?>"><?php echo $status; ?></td>
    </tr>
    <tr>
      <th scope="row">8</th>
      <td>PROBLEM</td>
        <td><?php echo $prob; ?></td>
    </tr> 
  </tbody>
</table>

</body>
</html>