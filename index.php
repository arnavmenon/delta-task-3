<?php include('processes/server.php');

if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

if(isset($_POST['logout'])){

  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");

}
?>

<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <title>Homepage</title>
    <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">

</head>

  <body>

    <div class="sidenav">
      <a href="index.php">Home</a>
      <a href="newinvite.php">Create new Event </a>
      <a href="inbox.php">Received Invitations</a>
      <a href="sent.php">Sent Invitations</a>
    </div>


   <div class="main">
     <h1>Homepage</h1>


    <?php
    if(isset($_SESSION['success'])) :  ?>



      <h3>
        <?php
        echo($_SESSION['success']);
        unset($_SESSION['success']);
        ?>
      <h3>


  <?php endif ?>



  <?php if(isset($_SESSION['username'])) : ?>

    <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    <p><form method="post">
      <button type="submit" name="logout">Logout</button></form></p>


   </div>

  <?php endif ?>




</body>

</html>
