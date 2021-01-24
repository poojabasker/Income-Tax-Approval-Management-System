<?php
session_start();
if(!$_SESSION['code'])
{
    header('Location: officer.php');
    return;
}

require_once('dbconnect.php');
$code = $_SESSION['code'];
$q = " SELECT NAME FROM ASSESSING_OFFICER WHERE ID = '$code' LIMIT 1 ";
$res = mysqli_query($connection,$q);
$res = mysqli_fetch_array($res)['NAME'];
$connection->close();
?>

<!DOCTYPE html>
<html>

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
  <text class="navbar-brand">e-Tax Officer</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <text class="nav-link" href="userloginlinks.php"><?php echo $code; ?></text>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">LOGOUT</a> 
      </li>
    </ul>
  </div>
</nav>
</section>
<div style="text-align: center; padding-top:50px">
  <p><font size="7"><b>Welcome, <?php echo $res; ?>!</b></font></p>
</div>
<table class="table table-light table-hover" style="text-align: center; height: 250px; font-size: 20px; margin-top: 50px">
  <tbody>
    <tr>
      <td><a href="officerview.php"><u>Click here to view Personal Details</u></a></td>
    </tr>
    <tr>
      <td><a href="officerupdate.php"><u>Click here to edit Personal Details</u></a></td>
    </tr>
    <tr>
      <td><a href="approvelist.php"><u>Click here to view Approval List of Tax Payers</u></a></td>
    </tr>
</tbody>
</table>

</body>
</html>
