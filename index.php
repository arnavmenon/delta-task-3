<?php include('processes/server.php');
      include('dashboard.html');

if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}



$notif_query="SELECT * FROM responses WHERE seen='0' AND to_user='".$_SESSION['username']."'";
$result=mysqli_query($db,$notif_query);
$unseen=mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">

</head>

  <body>

   <div class="main">
     <h1>Homepage</h1>

    <?php
    if(isset($_SESSION['success'])) :  ?>
      <h4 style="color:blue;">
        <?php
        echo ($_SESSION['success']);
        unset($_SESSION['success']);
        ?>
      <h4>
      <?php endif ?>


  <?php if(isset($_SESSION['username'])) : ?>

    <p>Welcome <strong><?php echo $_SESSION['username'].'!'; ?></strong></p>
    <br>
    <h4><u>Notifications</u></h4>

    <?php
      if($unseen)
        echo '<p>You have <a href="inbox.php">'.$unseen.' new invite(s)</a></p>';
      else
        echo '<p>No new invites</p';

        ?>

   </div>

  <?php endif ?>


</body>

</html>
