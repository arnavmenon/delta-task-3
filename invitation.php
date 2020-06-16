<?php  include('processes/server.php');

if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

if(isset($_GET['invite_id'])){

$invite_id=$_GET['invite_id'];
$i=0;

$query="SELECT * FROM invites WHERE to_user='".$_SESSION['username']."' OR (to_user='' AND from_user!='".$_SESSION['username']."') ";
$result=mysqli_query($db,$query);

while($i<$invite_id)
{$row = mysqli_fetch_array($result);
  $i++;}

$a=htmlspecialchars_decode($row['header']);
$b=htmlspecialchars_decode($row['body']);
$c=htmlspecialchars_decode($row['footer']);
$_SESSION['invite_id']=$row['id'];

}


if(isset($_POST['accept'])){
  invite_reply($_SESSION['invite_id'],1);
  $_SESSION['success']="Invite Accepted !! ";
  header("location: index.php");
  }


if(isset($_POST['reject'])){
  invite_reply($_SESSION['invite_id'],0);
  $_SESSION['success']="Invite Rejected :( ";
  header("location: index.php");
}


 ?>

 <!DOCTYPE html>
 <html>
   <head>

     <meta charset="utf-8">
     <title>Invitation</title>
     <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">


     <style>

     .main {
       text-align: center;
       font-size: 28px;
       font-family:'Aclonica', sans-serif;
       margin-bottom: 50px;
     }

     .response{
       margin-left: 250px;
       margin-top: 100px;
       font-size: 28px;
       text-align: center;
       font-family:'Aclonica', sans-serif;
     }

     hr{
       margin-left: 250px;
       border: 2px solid black;
     }
   </style>


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
     if (isset($_GET['invite_id'])){
        echo $a,$b,$c;
      }
      ?>

      </div>

      <hr>

      <div class="response">

<?php if($row['accept']==-1) : ?>

    <div style="display:flex;justify-content: center;">

      <form  action='invitation.php' method="post">
        <button type="submit" name="accept">Accept</button>
      </form>

      <form  action="invitation.php" method="post">
        <button type="submit" name="reject">Reject</button>
      </form>

    </div>

<?php elseif ($row['accept']==1) : ?>

   <div style="display:flex;justify-content: center;">
     You have accepted this invitation!!
   </div>

 <?php else : ?>

   <div style="display:flex;justify-content: center;">
     You have rejected this invitation :{
   </div>

 <?php endif ?>

  </div>




   </body>

   </html>
