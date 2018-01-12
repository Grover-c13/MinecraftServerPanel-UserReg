<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ICannt Minecraft Player Registration</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='style2.css' rel='stylesheet' type='text/css'>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script src="js/google.js"></script>
    <script src="https://apis.google.com/js/client.js"></script>
    <script src="js/register.js"></script>
    
    <?php

    require_once "php/userdetails.php";
    $user = getUserByIp();
    print_r($user);
    if ($user !== false)
    {
      echo "<script>canReg = true;</script>";
    }
    
    
    ?>
    
  </head>
  <body>
    <div id="container">
      <?php include 'header.php'; ?>
      
      <div id="content">
        <p>
          Welcome to ICannt! in order to be able to build on any of the Minecraft based servers you will need to register your Minecraft username. If you have any trouble registering or dont fully understand please speak to a moderator or admin ingame so that we can assist you.
        </p>
        
        <br />
        <div id="form">
          <img src="php/mchead.php?name=<?php echo $name; ?>&amp;size=128" alt="" class="player_head" />
          
          <div class="right">
            <b>Minecraft Name</b><br />
            <input type="text" id="username" name="user" value="<?php echo $user; ?>">
            <img src="images/small-loading.gif" class="small-loader" id="sloader" alt=""/>
            <br />
            <span class="error" id="error"></span>
          </div>
        </div>
        
        <h2>Register with...</h2>
        <div id="register_options">
          
          <div class="register-option" data-register="fb">
            <img src="images/facebook.png" alt="Facebook">
            Facebook
          </div>
          
          <div class="register-option" data-register="tumblr" style="display: none;">
            <img src="images/tumblr.png" alt="Tumblr">
            Tumblr
          </div>
          
          <div class="register-option" data-register="steam">
            <img src="images/steam.png" alt="Steam">
            Steam
          </div>
          
          <div class="register-option" data-register="google">
            <img src="images/google.png" alt="Google">
            Google
          </div>

          
          <div class="register-option" data-register="email">
            <img src="images/email.png" alt="Email">
            Email
          </div>
          
          
        </div>
        <br />
        <p class="small">
          
        </p>
      </div>
      
    
      

      
      <?php
        include "templates/loading.php";
        include "templates/success.php";
        include "templates/failure.php";
      ?>
      
    </div>
    
    <?php include 'templates/footer.php'; ?>
  </body>
</html>