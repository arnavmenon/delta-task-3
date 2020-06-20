<?php include('processes/server.php');

if(!isset($_SESSION['username'])){
  $_SESSION['msg']="You must login to view this page";
  header("location: login.php");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';
$mail_array=array();$j=0;


if(isset($_POST['sendinvite'])){


  $sumquery="SELECT * FROM invites";
  $sumresult=mysqli_query($db,$sumquery);
  $numrows=mysqli_num_rows($sumresult);
  $newinviteid=$numrows+1;


  $from_user=$_SESSION['username'];

  $invitees=explode(",",mysqli_real_escape_string($db,$_POST['receipient']));

  $header0=mysqli_real_escape_string($db,$_POST['header']);
  $header=htmlspecialchars("<h1>".$header0."</h1>");

  $body0=mysqli_real_escape_string($db,$_POST['body']);
  $body=htmlspecialchars("<p>".$body0."</p>");

  $footer0=mysqli_real_escape_string($db,$_POST['footer']);
  $footer=htmlspecialchars("<footer>".$footer0."</footer>");

  $date=$_POST['event_date'];$time=$_POST['event_time'];
  $deadline=$_POST['deadline'];


for($i=0;$i<count($invitees);$i++)
{   $invite_query="INSERT INTO invites (from_user, event_date, event_time, invite_id, header, body, footer, deadline) VALUES ('$from_user', '$date', '$time', '$newinviteid', '$header', '$body', '$footer', '$deadline')";
    //$invite_query="INSERT INTO invites (from_user, to_user, invite_id, header, body, footer) VALUES ('$from_user', '$invitees[$i]', '$newinviteid', '$header', '$body', '$footer')";
    $responses_entry="INSERT INTO responses (invite_id, to_user) VALUES ('$newinviteid', '$invitees[$i]')";
    mysqli_query($db,$invite_query);
    mysqli_query($db,$responses_entry);
  }


  $mail_query="SELECT username, email FROM userdata";
  $mail_result=mysqli_query($db,$mail_query);


  for($i=0;$i<mysqli_num_rows($mail_result);$i++)
    { $mail_row=mysqli_fetch_array($mail_result);
      for($j=0;$j<count($invitees);$j++)
      {
        if($invitees[$j]==$mail_row['username'])
        {
          array_push($mail_array,$mail_row['email']);
        }
      }
    }

    $a=htmlspecialchars_decode($header);
    $b=htmlspecialchars_decode($body);
    $c=htmlspecialchars_decode($footer);


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $_POST['mailun'];                 // SMTP username
    $mail->Password = $_POST['mailpw'];                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom($_POST['mailun']);

    for($i=0;$i<count($mail_array);$i++)
      $mail->addAddress($mail_array[$i]);     // Add a recipient
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "Invitation for ".$header0;
    $mail->Body    = "".$a.$b.$c."";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();

    echo "<script>alert('Invite and mail have been sent !');</script>";

} catch (Exception $e) {
  echo "<script>alert('Invite sent, mail not sent. Sorry!');</script>";
}


}
?>

<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <title>New Invitation</title>
    <link href="styles/dashboard.php" rel="stylesheet" type="text/css">
    <link href="styles/newinvitestyle.php" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Yatra+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">

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
           <div class="fieldname"> <label name="event_date">Event Date</label> </div>
           <input type="date" name="event_date">
         </div>

         <div class="inputfield">
           <div class="fieldname"> <label name="event_time">Event Time</label> </div>
           <input type="time" name="event_time">
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

          <div class="inputfield">
            <div class="fieldname"> <label name="deadline">Deadline to Accept</label> </div>
            <input type="date" name="deadline">
          </div>

          <br>

          <div class="inputfield">
            <input type="checkbox" name="sendmail" value="sendmail" id="mailopt">
            <label name="sendmail">Send Invitation via E-mail (Only GMail supported)</label>
          </div>

          <div class="inputfield" id="maildetails">

            <div class="fieldname">
              <label name="mailun">Gmail ID </label>
              <input type="text" name="mailun" id="mailun">
            </div>
            <div class="inputfield">
              <label name="mailpw">Password</label>
              <input type="password" name="mailpw" id="mailpw" placeholder="This will not be saved">
            </div>

          </div>

          <br>

          <button id="send" type="submit" name="sendinvite">Send</button>


    </form>


  </div>

 <script type="text/javascript">

 let mailopt=document.getElementById("mailopt");
 let mailun=document.getElementById('mailun'),mailpw=document.getElementById('mailpw');

  document.getElementById("pvt").addEventListener("click",function(){
    document.getElementById('receipientlist').style.display="block";
  });

  document.getElementById("send").addEventListener("click",function(){
    document.getElementById('receipientlist').style.display="block";
  });

  mailopt.addEventListener("click",function(){
    if(mailopt.checked==true){
      document.getElementById('maildetails').style.display="block";
    }
    else{
      mailun.value=mailpw.value="";
      document.getElementById('maildetails').style.display="none";
    }
  });


 </script>

  </body>

  </html>
