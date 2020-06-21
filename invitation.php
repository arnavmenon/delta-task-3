<?php  include('processes/server.php');
include('dashboard.html');


if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

if(isset($_GET['invite_id'])){

$invite_id=$_GET['invite_id'];
$_SESSION['invite_id']=$invite_id;
$i=0;

$query="SELECT * FROM invites WHERE invite_id='".$invite_id."'";
$result=mysqli_query($db,$query);
$row = mysqli_fetch_array($result);

$check="SELECT * FROM responses WHERE invite_id='".$invite_id."' AND to_user='".$_SESSION['username']."'";
$access_check=mysqli_num_rows(mysqli_query($db,$check));
if (!$access_check)
  header("location: index.php");


$seen_query="UPDATE responses SET seen='1' WHERE invite_id='".$invite_id."' AND to_user='".$_SESSION['username']."'";
mysqli_query($db,$seen_query);



$a=htmlspecialchars_decode($row['header']);
$b=htmlspecialchars_decode($row['body']);
$c=htmlspecialchars_decode($row['footer']);

$from=$row['from_user'];
$date=$row['event_date'];
$time=$row['event_time'];
$deadline=$row['deadline'];
$_SESSION['invite_id']=$row['invite_id'];

}

  if(isset($_POST['sendresponse'])){
    invite_reply($_SESSION['invite_id'],1);
    $p=$_POST['plusones'];$f=$_POST['foodpref'];$r=$_POST['requests'];
    $response_query="UPDATE responses SET plusones='".$p."',food_pref='".$f."',requests='".$r."' WHERE invite_id='".$_SESSION['invite_id']."' AND to_user='".$_SESSION['username']."'";
    mysqli_query($db,$response_query);
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
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Invitation</title>
     <link href="styles/invitationstyle.php" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">

   </head>

   <body>

     <div class="main">

     <?php


     if (isset($a))

    { echo $a;
      echo '<div class="dt"><span class="from"><img src="images/fromicon.png" id="from"><u>'.$from.'</u></span>&nbsp';
      echo '&nbsp&nbsp&nbsp<span class="date"><img src="images/dateicon.png" id="date"><u>'.$date.'</u></span>&nbsp';
      echo '&nbsp&nbsp&nbsp<span class="time"><img src="images/timeicon.png" id="time"><u>'.$time.'</u></span></div><br>';
      echo $b,$c;
  }


      ?>

      </div>

      <hr class="invitationline">

      <div class="response">

<?php

  $accept_query="SELECT * FROM responses WHERE invite_id='".$_SESSION['invite_id']."' AND to_user='".$_SESSION['username']."'";
  $accept_result=mysqli_query($db,$accept_query);
  $accept_row=mysqli_fetch_array($accept_result);


  if($accept_row['accept']==-1) : ?>

  <div style="display:block;justify-content: center;">

  <div>
    <?php echo 'Deadline to Accept : '.$deadline.' ';?>
  </div>

        <br>

    <div style="display:flex;justify-content: center;">

        <button type="submit" name="accept" id="acc">Accept</button>


      <form  id="rejform" action='invitation.php' method="post">

        <button type="submit" name="reject" id="rej">Reject</button>
      </form>

    </div>

<?php elseif ($accept_row['accept']==1) : ?>

   <div style="display:flex;justify-content: center;">
     You have accepted this invitation!!
   </div>

 <?php else : ?>

   <div style="display:flex;justify-content: center;">
     You have rejected this invitation :{
   </div>

 <?php endif ?>

  </div>

  <br>

  <form action="invitation.php" method="post" id="responseform">

         <div class="inputfield">
           <div class="fieldname"> <label name="plusones">How many people(Including you)?</label> </div>
           <input type="number" name="plusones" min="1" value="1">
         </div>

         <div class="inputfield">
           <div class="fieldname"> <label name="foodpref">Food Preferences</label> </div>
           <select name="foodpref">
              <option value="Veg" selected>Veg</option>
              <option value="Non-Veg">Non-Veg</option>
          </select>
         </div>

         <div class="inputfield">
           <div class="fieldname"> <label name="requests">Any other requests?</label> </div>
           <input type="text" name="requests">
         </div>

         <button id="send" type="submit" name="sendresponse">Submit</button>

       </form>



  <script>

    document.getElementById("acc").onclick=function(){

       document.getElementById("responseform").style.display="block";
       document.getElementById("rejform").style.display="none";


    }

  </script>


   </body>

   </html>
