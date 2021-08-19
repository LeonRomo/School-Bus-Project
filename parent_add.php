<?php
// Include config file
require_once "parent_config.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $mobilenumber  = $email = $routeid = "";
$firstname_err = $lastname_err =  $mobilenumber_err = $email_err = $routeid_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate firstname
    $input_firstname = trim($_POST["firstname"]);
    if(empty($input_firstname)){
        $firstname_err = "Please enter First Name.";
    } elseif(!filter_var($input_firstname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $firstname_err = "Please enter a valid name.";
    } else{
        $firstname = $input_firstname;
    }
    
    // Validate lastname
    $input_lastname = trim($_POST["lastname"]);
    if(empty($input_lastname)){
        $lastname_err = "Please enter Last Name.";     
    } else{
        $lastname = $input_lastname;
    }
    
   
    // Validate mobile number
    $input_mobilenumber = trim($_POST["mobilenumber"]);
    if(empty($input_mobilenumber)){
        $mobilenumber_err = "Please enter the mobile number.";     
    } elseif(!ctype_digit($input_mobilenumber)){
        $mobilenumber_err = "Please enter a positive integer value.";
    }
     else{
        $mobilenumber = $input_mobilenumber;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the email.";     
    } else{
        $email = $input_email;
    }

    //Validate routeID
    $input_routeid = trim($_POST["routename"]);
    if(empty($input_routeid)){
        $routeid_err = "Please enter the Route ID.";     
    } else{
        $routeid = $input_routeid;
        
    }

    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err)  && empty($mobilenumber_err) && empty($email_err) && empty($routeid_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO parent (parent_firstName, parent_lastName, parent_mobileNumber, parent_email, parent_route_name) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiss", $param_firstname, $param_lastname, $param_mobilenumber, $param_email, $param_routeid);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
         
            $param_mobilenumber = $mobilenumber;
            $param_email = $email;
            $param_routeid = $routeid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: parent_module.php");
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                            <label>First name</label>
                            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                            <span class="help-block"><?php echo $firstname_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                            <label>Last name</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            <span class="help-block"><?php echo $lastname_err;?></span>
                        </div>

                        
                       


                        <div class="form-group <?php echo (!empty($mobilenumber_err)) ? 'has-error' : ''; ?>">
                            <label>Mobile Number</label>
                            <input type="number" name="mobilenumber" class="form-control" value="<?php echo $mobilenumber; ?>">
                            <span class="help-block"><?php echo $mobilenumber_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($routeid_err)) ? 'has-error' : ''; ?>">
                            <label>Route Plate</label>
                            <select name="routename" id="routename">
                             <option>Options</option>
                             <option value="Utawala, 00101">Utawala, 00101</option>
                             <option value="Imara Daima, 00102">Imara Daima, 00102</option>
                              <option value="Pipeline, 00103">Pipeline, 00103</option>    
                              <option value="Westlands, 00104">Westlands, 00104</option>    
                              <option value="Syokimau, 00105">Syokimau, 00105</option> 


                              </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="parent_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>