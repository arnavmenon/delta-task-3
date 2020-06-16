<?php include('processes/server.php');

if(isset($_SESSION['username'])){
  header("location: index.php");
} ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link href="styles/logstyle.php" rel="stylesheet" type="text/css">

  </head>

  <body>

    <div class="login_box">

      <div class="header">
          Sign In
      </div>


      <div>

      <form action="login.php" method="post">

        <?php include('processes/error.php') ?>


         <div class="inputlabel">
           <label for="username">Username </label>
           <input type="text" name="username">
        </div>


        <div class="inputlabel">
            <label for="p_word1">Password </label>
            <input type="password" name="p_word1">
        </div>

          <button type="submit" name="login_user">Login</button>

        </div>

      </form>

      <div class="registerprompt">
        New user? <a href="registration.php"><b>Register here</b></a>
      </div>


    </div>

</body>


</html>
