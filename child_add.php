<?php
// Include config file
require_once "parent_config.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $class  = $DOB = "";
$firstname_err = $lastname_err =  $class_err = $DOB_err =  "";


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

        // Validate class
        $input_class = trim($_POST["class"]);
        if(empty($input_class)){
            $class_err = "Please enter the class.";     
        } else{
            $class = $input_class;
        }
    
   
   

    // Validate date
    $input_DOB = trim($_POST["date"]);
    if(empty($input_DOB)){
        $DOB_err = "Please enter the date.";     
    } else{
        $DOB = $input_DOB;
    }

  

    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($lastname_err)  && empty($class_err) && empty($DOB_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO child (child_firstName, child_lastName, child_class, child_DOB) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssis", $param_firstname, $param_lastname, $param_class, $param_DOB);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
         
            $param_class = $class;
            $param_DOB = $DOB;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: child_module.php");
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

                        
                       


                        <div class="form-group <?php echo (!empty($class_err)) ? 'has-error' : ''; ?>">
                            <label>Class</label>
                            <select name="class" id="class" value = "<?php echo $class; ?>">
                                 <option>Options</option>
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option> 
                                 <option value="4">4</option> 
                                 <option value="5">5</option>   
                                 <option value="6">6</option> 
                                 <option value="7">7</option> 
                                 <option value="8">8</option> 
                                  
                             </select>
                            
                            <span class="help-block"><?php echo $class_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($DOB_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="date" name="date" class="form-control" value="<?php echo $DOB; ?>">
                            <span class="help-block"><?php echo $DOB_err;?></span>
                        </div>

                  
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="child_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>