<?php
session_start();
require_once('dbconnect.php');
$code = $_SESSION['code'];
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
  <text class="navbar-brand">e-Tax Officer Approval List</text>
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

<p><br><font size="5" style="padding-left: 10px"><b>APPROVAL LIST</b></font></p>
<table class="table table-striped table table-bordered">
  <thead>
    <tr>
      <th scope="col">SERIAL NUMBER</th>
      <th scope="col">NAME</th>
      <th scope="col">PAN NUMBER</th>
      <th scope="col">ASSESSMENT YEAR</th>
      <th scope="col">STATUS</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
        $q1 = " SELECT t.FNAME,t.LNAME,p.PAN_NO,p.ASSESS_YEAR,p.STATUS FROM TAX_PAYER t, INCOME_TAX i, PAYMENT p WHERE ID = '$code' AND t.PAN_NO = i.PAN_NO AND p.PAN_NO = t.PAN_NO AND p.STATUS = 'APPROVAL PENDING' ";
        $res1 = mysqli_query($connection,$q1);
        $i=0;
        if(mysqli_num_rows($res1)>0)
        {
          while($val1 = mysqli_fetch_array($res1))
          {
            if($val1['STATUS'] == 'APPROVAL PENDING')
            {
              $pan = $val1['PAN_NO'];
                $i=$i+1;
                echo "<tr><th scope='row'>".$i."</th><td>".$val1['FNAME']." ".$val1['LNAME']."</td><td>".$pan."</td><td>".$val1['ASSESS_YEAR']."</td><td>".$val1['STATUS']."</td><td><a href='approvedetails.php?pan=".$pan."'>[View Details]</a></td></tr>";
            }
          }
        }

        $connection->close();
      ?>
  </tbody>
</table>

</body>
</html>