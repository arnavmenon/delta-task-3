<?php
include ('password.php');
session_start();

$username="";
$email="";
$errors=array();

$db=mysqli_connect('localhost','root',$password,'inviteapp');

if(isset($_POST['login_user'])){

  $username=mysqli_real_escape_string($db,$_POST['username']);
  $p_word1=mysqli_real_escape_string($db,$_POST['p_word1']);

  if(empty($username)) array_push($errors,"Username is required");
  if(empty($p_word1)) array_push($errors,"Password is required");

  if(count($errors)==0)
  {
    $stmt =$db->prepare("SELECT* FROM userdata WHERE username=? AND p_word=? ");
    $stmt->bind_param('ss',$username,$p_word1);
    $stmt->execute();
    $results = $stmt->get_result();

    if(mysqli_num_rows($results)){

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
  $conn=new mysqli('localhost','root',$password,'inviteapp');
  $stmt =$conn->prepare("UPDATE invites SET accept=? WHERE id=?");
  $stmt->bind_param('ii',$reply,$id);
  $stmt->execute();
  $conn->close();
}


?>
