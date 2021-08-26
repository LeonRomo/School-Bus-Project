<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: homepage.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="dashboard.js"></script>
    </style>
</head>
<body>
<main class="main-holder-homepage">
     
     <div id="sidebar" class="side-bar">
         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
         <a href="feedback.php">Send Feedback</a> 
         <a href="notifications.php">Notifications</a>  
         <a href="password_reset.php">Change Password</a>  
        
     </div>

     <div id = "main">
         <button class="openbtn" onclick="openNav()">☰ Menu</button>
     </div>

     


 </main>

</body>
</html>