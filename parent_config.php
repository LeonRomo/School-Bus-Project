<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "school_transport");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Print host information
//echo "Connect Successfully. Host info: " . mysqli_get_host_info($link);

// Prepare an insert statement
/* $sql = "INSERT INTO parent (parent_firstName, parent_lastName, parent_mobileNumber,parent_email, parent_password, route_id) VALUES (?, ?, ?, ?, ?, ?)";
 
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssissi", $first_name, $last_name, $mobile_number, $email, $pwd, $route);
    
    // Set parameters
    $first_name = $_REQUEST['Firstname'];
    $last_name = $_REQUEST['Lastname'];
    $mobile_number = $_REQUEST['mobile_number'];
    $email = $_REQUEST['email'];
    $pwd = $_REQUEST['password'];
    $route = $_REQUEST['route'];
    
   
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
    }
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
}
 
// Close statement
mysqli_stmt_close($stmt);
 
 
// Close connection
mysqli_close($link);
?>
*/