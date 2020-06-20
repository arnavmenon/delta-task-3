<?php
include ('password.php');
session_start();

$username="";
$email="";
$errors=array();
$invite_id;

$db=mysqli_connect('localhost',$sqlusername,$sqlpassword,'inviteapp');

if(isset($_POST['login_user'])){

  $username=mysqli_real_escape_string($db,$_POST['username']);
  $p_word1=mysqli_real_escape_string($db,$_POST['p_word1']);

  if(empty($username)) array_push($errors,"Username is required");
  if(empty($p_word1)) array_push($errors,"Password is required");

  if(count($errors)==0)
  {
    $stmt =$db->prepare("SELECT* FROM userdata WHERE username=?");
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $results = $stmt->get_result();
    $row=$results->fetch_assoc();

    if(password_verify($p_word1,$row['p_word']))
    {

      $_SESSION['username']=  $username;
      $_SESSION['success']="Logged in successfully";
      header("location: index.php");

    }
    else{
      array_push($errors,"Wrong username/password. Please try again");
    }

}
}


if(isset($_POST['reg_user'])){

  $username=mysqli_real_escape_string($db,$_POST['username']);
  $email=mysqli_real_escape_string($db,$_POST['email']);
  $p_word1=mysqli_real_escape_string($db,$_POST['p_word1']);
  $p_word2=mysqli_real_escape_string($db,$_POST['p_word2']);

  //form validation
  if(!ctype_alnum($username)) array_push($errors,"Username can only contain letters and numbers");
  if(empty($username)) array_push($errors,"Username is required");
  if(empty($email)) array_push($errors,"Email is required");
  if(empty($p_word1)) array_push($errors,"Password is required");
  if($p_word1 != $p_word2) array_push($errors,"Passwords do not match");

  //check for existing acc

  $stmt =$db->prepare("SELECT * FROM userdata WHERE username =? OR email =? LIMIT 1");
  $stmt->bind_param('ss',$username,$email);
  $stmt->execute();
  $results = $stmt->get_result();
  $user = $results->fetch_assoc();


  if($user)
  {
    if($user['username']===$username) array_push($errors,"Username is taken");
    if($user['email']===$email) array_push($errors,"Email Id is already registered to a user");

  }

  if(count($errors)==0)
  {
    $p_word1=password_hash($p_word1 , PASSWORD_DEFAULT);
    mysqli_query($db,$register_query);
    $stmt =$db->prepare("INSERT INTO userdata (username, email, p_word) VALUES (?,?,?)");
    $stmt->bind_param('sss',$username,$email,$p_word1);
    $stmt->execute();

    $_SESSION['username']=  $username;
    $_SESSION['success']="You are now logged in";

    header("location: index.php");
  }

}

function invite_reply($id,$reply){
  include ('password.php');
  $conn=new mysqli('localhost',$sqlusername,$sqlpassword,'inviteapp');
  $stmt =$conn->prepare("UPDATE responses SET accept=? WHERE invite_id=? AND to_user=?");
  $stmt->bind_param('iis',$reply,$id,$_SESSION['username']);
  $stmt->execute();
  $conn->close();
}


?>
