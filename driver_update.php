<?php
// Include config file
require_once "bus_config.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $mobilenumber = $email = $busid =  "";
$firstname_err = $lastname_err  = $mobilenumber_err = $email_err = $busid_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate bus first name
    $input_firstname = trim($_POST["firstname"]);
    if(empty($input_firstname)){
        $firstname_err = "Please enter the First Name.";
    }else{
        $firstname = $input_firstname;
    }
    
    // Validate last name
    $input_lastname = trim($_POST["lastname"]);
    if(empty($input_lastname)){
        $lastname_err = "Please enter the Last Name.";     
    } else{
        $lastname = $input_lastname;
    }

   

      // Validate mobile number
    $input_mobilenumber = trim($_POST["mobilenumber"]);
    if(empty($input_mobilenumber)){
        $mobilenumber_err = "Please enter the Mobile Number.";     
    } else{
        $mobilenumber = $input_mobilenumber;
    }

     // Validate Email
     $input_email = trim($_POST["email"]);
     if(empty($input_email)){
         $email_err = "Please enter the Email.";     
     } else{
         $email = $input_email;
     }

      // Validate Bus ID
      $input_busid = trim($_POST["busplate"]);
      if(empty($input_busid)){
          $busid_err = "Please select the Bus plate.";     
      } else{
          $busid = $input_busid;
      }
    
   
    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err)  && empty($mobilenumber_err) && empty($email_err) && empty($busid_err)){
        // Prepare an update statement
        $sql = "UPDATE driver SET driver_firstName=?, driver_lastName=?, driver_mobileNumber=?, driver_email=?,driver_bus_number_plate=? WHERE driver_id=?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssissi", $param_firstname, $param_lastname, $param_mobilenumber, $param_email, $param_busid, $param_id);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
           
            $param_mobilenumber = $mobilenumber;
            $param_email = $email;
            $param_busid = $busid;
           
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: driver_module.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM driver WHERE driver_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $firstname = $row["driver_firstName"];
                    $lastname = $row["driver_lastName"];
                    
                    $mobilenumber = $row["driver_mobileNumber"];
                    $email = $row["driver_email"];
                    $busid = $row["driver_bus_number_plate"];
                    
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                            <span class="help-block"><?php echo $firstname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            <span class="help-block"><?php echo $lastname_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($mobilenumber_err)) ? 'has-error' : ''; ?>">
                            <label>Mobile Number</label>
                            <input type="number" name="mobilenumber" class="form-control" value="<?php echo $mobilenumber; ?>">
                            <span class="help-block"><?php echo $mobilenumber_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        

                        <div class="form-group <?php echo (!empty($busid_err)) ? 'has-error' : ''; ?>">
                            <label>Bus Plate</label>
                            <select name="busplate" id="bus plates">
                                 <option>Options</option>
                                 <option value="KCQ-692-P">KCQ-692-P</option>
                                 <option value="KCD-110-W">KCD-110-W</option>
                                 <option value="KCM-567-S">KCM-567-S</option> 
                                 <option value="KCF-843-L">KCF-843-L</option> 
                                 <option value="KDA-432-K">KDA-432-K</option>    
                             </select>
                            
                        </div>


                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="driver_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
