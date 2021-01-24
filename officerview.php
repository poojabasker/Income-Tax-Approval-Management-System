<?php
session_start();
require_once('dbconnect.php');

if(isset($_POST['sbutton']))
{
  $pan=$_POST['search'];
  $_SESSION['pan']=$pan;
  if(strlen($pan)!=10)
    echo "<script> alert('Wrong PAN Number.'); window.location = window.history.back() </script>";
  else if(strlen($pan)==10)
  {
    $q1 = " SELECT * FROM TAX_PAYER WHERE PAN_NO = '$pan' ";
    $res1 = mysqli_query($connection,$q1);
    if(mysqli_num_rows($res1) == 1)
     header('Location: searchpan.php');
    else
    echo "<script> alert('PAN Number not found.'); window.location = window.history.back() </script>";
  }
}

$code = $_SESSION['code'];

$q1 = " SELECT * FROM ASSESSING_OFFICER WHERE ID = '$code' ";
$res1 = mysqli_query($connection,$q1);
$val1 = mysqli_fetch_array($res1);
$fullname = $val1['NAME'];
$email = $val1['EMAIL'];
$bname = $val1['BUILD_NAME'];
$wc = $val1['WC'];
$city = $val1['CITY'];
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
  <text class="navbar-brand">e-Tax Officer View</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
       <li class="nav-item">
        <text class="nav-link"><?php echo $code; ?></text> 
      </li>
      <li class="nav-item">
        <a class="nav-link" href="officerloginlinks.php">BACK</a> 
      </li>
    </ul>
  </div>
</nav>
</section>

<p><br><font size="5" style="padding-left: 10px"><b>OFFICER DETAILS</b></font></p>
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
      <td><?php echo $fullname; ?></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>AO CODE</td>
      <td><?php echo $code; ?></td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>WARD/CIRCLE</td>
      <td><?php echo $wc; ?></td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td>EMAIL ID</td>
      <td><?php echo $email; ?></td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td>BUILD NAME</td>
      <td><?php echo $bname; ?></td>
    </tr>
    <tr>
      <th scope="row">7</th>
      <td>STATUS</td>
      <td><?php echo $city; ?></td>
    </tr>
  </tbody>
</table>

<p><br><font size="5" style="padding-left: 10px"><b>TAX PAYERS UNDER OFFICER</b></font> 
  <div style="padding-left: 10px">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="form1">
  <input type="text" id="search" name="search" placeholder="Enter PAN number..." tabindex="-1">
   <input type="submit" name="sbutton" value="Search" class="btn btn-secondary" tabindex="-1">
</form></div></p>

<?php 

?>

<table class="table table-striped table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="width: 33%">SERIAL NUMBER</th>
      <th scope="col" style="width: 33%">NAME</th>
      <th scope="col">PAN NUMBER</th>
    </tr>
  </thead>
  <tbody>
    <?php
        $q2 = " SELECT FNAME,LNAME,PAN_NO FROM TAX_PAYER WHERE ID = '$code' ";
        $res2 = mysqli_query($connection,$q2);
        $i=0;
        if(mysqli_num_rows($res2) > 0)
        {
          while($val2 = mysqli_fetch_array($res2))
          {
            $i=$i+1;
            echo "<tr><th scope='row'>".$i."</th><td>".$val2['FNAME']." ".$val2['LNAME']."</td><td>".$val2['PAN_NO']."</td><tr>";
          }
        }
        else
          echo "<tr><th scope='row'>".($i+1)."</th><td>-</td><td>-</td><tr>";

        $connection->close();
      ?>
  </tbody>
</table>

</body>
</html>