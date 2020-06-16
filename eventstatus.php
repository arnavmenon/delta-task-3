<?php include('processes/server.php');

if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

$status_id=$_GET['status_id'];

$query="SELECT * FROM invites WHERE invite_id='".$status_id."'";
$result=mysqli_query($db,$query);
$x=mysqli_query($db,$query);

 ?>



 <!DOCTYPE html>
 <html>
   <head>

     <meta charset="utf-8">
     <title>Outbox</title>
     <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">


 </head>

   <body>

     <div class="sidenav">
       <a href="index.php">Home</a>
       <a href="newinvite.php">Create new Event</a>
       <a href="inbox.php">Received Invitations</a>
       <a href="sent.php">Sent Invitations</a>
     </div>

     <div class="main">

      <?php
        $a=mysqli_fetch_array($x);
        echo '<h1>'.htmlspecialchars_decode($a['header']).'</h1>';
       ?>

       <h3>List of Invitees</h3>

       <?php

       $num=0;
       while($row=mysqli_fetch_array($result))
          { $num++;
            echo "<p>".$num.".".$row['to_user']."-";

            if($row['accept']==-1) : ?>
              No reply yet</p>
        <?php elseif($row['accept']==1) : ?>

            <span style="color:green;">Attending</span></p>

        <?php  else : ?>
            <span style="color:red;">NOT Attending</span></p>

        <?php endif ;
      }; ?>

     </div>


   </body>

</html>
