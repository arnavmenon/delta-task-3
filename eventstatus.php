<?php include('processes/server.php');
include('dashboard.html');


if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

$status_id=$_GET['status_id'];

$query="SELECT * FROM invites WHERE invite_id='".$status_id."'";
$result=mysqli_query($db,$query);
$x=mysqli_query($db,$query);

$num_query="SELECT SUM(plusones) FROM responses WHERE invite_id='".$status_id."'";
$num_result=mysqli_query($db,$num_query);
$num=mysqli_fetch_array($num_result);

$check="SELECT * FROM invites WHERE invite_id='".$status_id."' AND from_user='".$_SESSION['username']."'";
$access_check=mysqli_num_rows(mysqli_query($db,$check));
if (!$access_check)
  header("location: index.php");

$namelist="SELECT * FROM responses WHERE invite_id='".$status_id."'";
$publiclist=mysqli_query($db,$namelist);

 ?>



 <!DOCTYPE html>
 <html>
   <head>

     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Outbox</title>
     <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">


 </head>

   <body>

     <div class="main">

      <?php
        $a=mysqli_fetch_array($x);
        echo '<h1>'.htmlspecialchars_decode($a['header']).'</h1>';
        echo '<p>Number of confirmed attendants- '.$num['SUM(plusones)'].'</p>';
       ?>

       <h3><u>List of Invitees</u></h3>

       <?php

       $num=0;
       while($row=mysqli_fetch_array($publiclist))

          { $num++;
            echo "<p>".$num.".".$row['to_user']."-";

            if($row['accept']==-1)
              echo 'No reply yet</p>';

            elseif($row['accept']==1)
            {echo '<span style="color:green;">Attending</span></p>';
            echo '<p><strong>No. of people-</strong>'.$row['plusones'].'&nbsp&nbsp&nbsp<strong>Food Preference-</strong>'.$row['food_pref'].'</p>';
            echo '<p><strong>Addl. Requests-</strong>'.$row['requests'].'</p><br>';
            }

            else
              echo '<span style="color:red;">NOT Attending</span></p>';

            };


      ?>

     </div>


   </body>

</html>
