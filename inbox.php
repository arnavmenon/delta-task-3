<?php include('processes/server.php');
$link_address="invitation.php";

if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}


 ?>


 <!DOCTYPE html>
 <html>
   <head>

     <meta charset="utf-8">
     <title>Inbox</title>
     <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">

     <style>

      #newicon{
        width: 35px;
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
       <h1>Received Invitations</h1>

       <?php

       $invitelist=array();

       $query="SELECT * FROM responses WHERE to_user='".$_SESSION['username']."'";
       $result=mysqli_query($db,$query);
       while($row=mysqli_fetch_array($result)){
         array_push($invitelist,$row['invite_id']);
       }

       $newquery="SELECT * FROM invites";
       $newresult=mysqli_query($db,$newquery);
       $num=1;
       while($newrow=mysqli_fetch_array($newresult))
       {
         for($i=0;$i<count($invitelist);$i++)
        {  if($invitelist[$i]==$newrow['invite_id'])
        {
         $eventname=htmlspecialchars_decode($newrow['header']);
         $eventname=str_replace("<h1>","",$eventname);
         $eventname=str_replace("</h1>","",$eventname);
         $seen_query="SELECT * FROM responses WHERE invite_id='".$invitelist[$i]."' AND to_user='".$_SESSION['username']."'";
         $seen_row=mysqli_fetch_array(mysqli_query($db,$seen_query));
         if($seen_row['seen']=='0')
            echo "<h3>".$num++.".".$eventname.'&nbsp<img src="images/newicon.png" id="newicon"></h3>';
         else
           echo "<h3>".$num++.".".$eventname.'</h3>';

         //echo "<h3>".$num.".".$eventname.'</h3>';
         echo "From: ".$newrow['from_user'] ;
         echo "<p><a href='".$link_address."?invite_id=$invitelist[$i]'>View</a></p>";
          }}
       }

       if($num==1) echo "<h2>No new Invitations</h2>";




        ?>
