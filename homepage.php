<?php

require_once("admin_config.php");

if(isset($_POST['admin_submit'])){
  $admin_email = $_POST['email'];
  $admin_password = $_POST['password'];

  if(!empty($admin_email) && !empty($admin_password)){
    $sql = "SELECT * FROM login WHERE login_username = '$admin_email'";
    $result = mysqli_query($link, $sql);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          $pwd = $row['login_password'];
      
        if($pwd == $admin_password){
          $sql = "UPDATE admininstrator SET administrator_last_login = CURRENT_TIMESTAMP WHERE administrator_email = '$admin_email'";
          $query = mysqli_query($link, $sql);

          session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION['userId'] = $row['login_id'];
          // redirect to?
          header("location: dashboard.php");
        }else{
          echo "Invalid email or password";
        }
      }
    }else{
      echo "User does not exist";
    }
  }else{
    echo "Please enter login details";
  }
}

//driver login
if(isset($_POST['driver_submit'])){
  $driver_email = $_POST['email'];
  $driver_password = $_POST['password'];

  
  

  if(!empty($driver_email) && !empty($driver_password)){
    $sql = "SELECT * FROM login WHERE login_username = '$driver_email'";
    $result = mysqli_query($link, $sql);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          $pwd = $row['login_password'];
      
        if($pwd == $driver_password){
          $sql = "UPDATE driver SET driver_last_login = CURRENT_TIMESTAMP WHERE driver_email = '$driver_email'";
          
          $query = mysqli_query($link, $sql);

          session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION['userId'] = $row['login_id'];
          // redirect to?
          header("location: welcomepage.php");
        }else{
          echo "Invalid email or password";
        }
      }
    }else{
      echo "User does not exist";
    }
  }else{
    echo "Please enter login details";
  }
}

//parent login
if(isset($_POST['parent_login'])){
  $parent_email = $_POST['email'];
  $parent_password = $_POST['password'];

  

  if(!empty($parent_email) && !empty($parent_password)){
    $sql = "SELECT * FROM login WHERE login_username = '$parent_email'";
    $result = mysqli_query($link, $sql);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          $pwd = $row['login_password'];
      
          if($pwd == $parent_password){
           

          
          session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION['userId'] = $row['login_id'];
          // redirect to?
          header("location: welcomepage.php");

        }else{
          echo "Invalid email or password";
        }
      }
    }else{
      echo "User does not exist";
    }
  }else{
    echo "Please enter login details";
  }
}


?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Login Form</title>
</head>
<body>
  <form action="" method="POST">
    <p>
      <label for="ranks">Login As: </label>
      <select name="ranks" id="ranks">
        <option>Options</option>
        <option value="admin">admin</option>
        <option value="driver">driver</option>
        <option value="parent">parent</option>    
      </select>
      
      <input type="submit" name="formBtn" id="submit" value="Login">
          

        
      
    </p>
  </form>

  <?php

  if (isset($_POST['formBtn'])) {
    $rank = $_POST['ranks'];

    // if set to login as admin
    if ($rank == 'admin') {
      ?>

        <fieldset>
          <legend>Admin Login</legend>
          <form name = "login_form" action="" method="POST">
            <p>
             <label for="email">Email</label> 
             <input type="email" name="email" id="email" required>
            </p>
            <p> 
              <label for="password">Password</label>
              <input type="password" name="password" id="password" required>
            </p>
            
             
          
            <p>&nbsp;</p>
            <p>
              <input type="submit" name="admin_submit" id="submit" value="Login">
            </p>
           </form>
        </fieldset>   
        
      
      <?php
    }
    // if set to login as driver
    elseif ($rank == 'driver') {
      
      ?>
        
      
        <fieldset>
          <legend>Driver Login</legend>
          <form name = "login_form" action="" method="POST">
            <p>
             <label for="email">Email</label> 
             <input type="email" name="email" id="email">
            </p>
            <p> 
              <label for="password">Password</label>
              <input type="password" name="password" id="password">
            </p>
          
            <p>&nbsp;</p>
            <p>
              <input type="submit" name="driver_submit" id="submit" value="Login">
            </p>
           </form>
        </fieldset>

      <?php
    }
    // if set to login as parent
    elseif ($rank == 'parent') {
      ?>

        <fieldset>
          <legend>Parent Login</legend>
          <form name = "login_form" action="" method="POST">
            <p>
             <label for="email">Email</label> 
             <input type="email" name="email" id="email">
            </p>
            <p> 
              <label for="password">Password</label>
              <input type="password" name="password" id="password">
            </p>
          
            <p>&nbsp;</p>
            <p>
              <input type="submit" name="parent_login" id="submit" value="Login">
            </p>
           </form>
        </fieldset>

      <?php
    }else{
      echo "<p style='color:red;'>Please set you want to login as</p>";
    }
  }

  ?>
     
</body>
</html>