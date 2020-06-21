<?php include('processes/server.php') ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
    <link href="styles/regstyle.php" rel="stylesheet" type="text/css">

  </head>

  <body>

    <div class="register_box">

      <div class="header">
          Register
      </div>

      <form action="registration.php" method="post">

        <?php include('processes/error.php') ?>

         <div class="inputlabel">
           <label for="username">Username:</label>
           <input type="text" name="username">
        </div>

        <div class="inputlabel">
            <label for="email">Email ID&nbsp&nbsp:&nbsp&nbsp</label>
            <input type="text" name="email">
        </div>

       <div class="inputlabel">
         <label for="p_word1">Password:</label>
         <input type="password" name="p_word1">
      </div>

      <div class="inputlabel">
        <label for="p_word2">Confirm Password:</label>
        <input type="password" name="p_word2">
     </div>

     <button type="submit" name="reg_user">Submit</button>

   </form>

   <div class="loginprompt">
      Already registered? <a href="login.php"><b>Login</b></a>
    </div>


 </div>

</body>


</html>
