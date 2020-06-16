<?php include('processes/server.php');


if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

if(isset($_POST['sendinvite'])){

  $sumquery="SELECT * FROM invites ORDER BY id DESC";
  $sumresult=mysqli_query($db,$sumquery);
  $row=mysqli_fetch_array($sumresult);
  $newinviteid=$row['invite_id']+1;

$from_user=$_SESSION['username'];

$invitees=explode(",",mysqli_real_escape_string($db,$_POST['receipient']));

$header=mysqli_real_escape_string($db,$_POST['header']);
$header=htmlspecialchars("<h1>".$header."</h1>");

$body=mysqli_real_escape_string($db,$_POST['body']);
$body=htmlspecialchars("<p>".$body."</p>");

$footer=mysqli_real_escape_string($db,$_POST['footer']);
$footer=htmlspecialchars("<footer>".$footer."</footer>");

for($i=0;$i<count($invitees);$i++)
{   $invite_query="INSERT INTO invites (from_user, to_user, invite_id, header, body, footer) VALUES ('$from_user', '$invitees[$i]', '$newinviteid', '$header', '$body', '$footer')";
    mysqli_query($db,$invite_query);
  }

$_SESSION['success']="Invite sent";
header("location: index.php");

}


?>

<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <title>New Invitation</title>
    <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">


    <style>

    input[type=text]{
      width: 80%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 3px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button[type=submit] {
      width: 80%;
      color: white;
      background-color: black;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .inputfield{
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .fieldname{
      font-size: 25px;
    }

    #receipientlist{
      display: none;
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

      <h1>New Invitation</h1>

    <form action="newinvite.php" method="post">

         <div class="inputfield">
           <div class="fieldname"> <label name="header">Header(Event Name)</label> </div>
           <input type="text" name="header">
         </div>


          <div class="inputfield">
            <div class="fieldname">
              Event Type:
              <input type="radio" name="eventtype" value="public" id="pub" checked>
              <label>Public</label>
              <input type="radio" name="eventtype" value="private" id="pvt">
              <label>Private</label>
           </div>
         </div>

          <div class="inputfield" id="receipientlist">
            <div class="fieldname">
              <label for="receipient">Add receipients (usernames with comma(,) in between)</label>
            </div>
            <input type="text" name="receipient" id="invitees" placeholder="If blank,invite is sent to all users!">
          </div>




          <div class="inputfield">
            <div class="fieldname"> <label for="body">Body</label> </div>
            <textarea name="body" rows="5" cols="138"></textarea>
          </div>

          <div class="inputfield">
            <div class="fieldname"> <label name="footer">Footer</label> </div>
            <input type="text" name="footer">
          </div>

          <button id="send" type="submit" name="sendinvite">Send</button>


    </form>


  </div>

 <script type="text/javascript">


  document.getElementById("pvt").addEventListener("click",function(){
    document.getElementById('receipientlist').style.display="block";
  });

  document.getElementById("pub").addEventListener("click",function(){
    document.getElementById("invitees").value="";
    document.getElementById('receipientlist').style.display="none";
  });

/*  document.getElementById("send").onclick=function(){
    if(document.getElementById("pvt").checked)
      if(document.getElementById("invitees").value=="")
        alert("Please enter list of invitees!");
  }
*/

 </script>

  </body>



  </html>
