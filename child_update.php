<?php
// Include config file
require_once "parent_config.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $class = $DOB =  "";
$firstname_err = $lastname_err  = $class_err = $DOB_err = "";
 
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

     // Validate password
   

      // Validate mobile number
    $input_class = trim($_POST["class"]);
    if(empty($input_class)){
        $class_err = "Please enter the Class.";     
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
        // Prepare an update statement
        $sql = "UPDATE child SET child_firstName=?, child_lastName=?, child_class=?, child_DOB=?  WHERE child_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisi", $param_firstname, $param_lastname, $param_class, $param_DOB, $param_id);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_class = $class;
            
            $param_DOB = $DOB;
        
           
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM child WHERE child_id = ?";
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
                    $firstname = $row["child_firstName"];
                    $lastname = $row["child_lastName"];
                    
                    $class = $row["child_class"];
                    $DOB = $row["child_DOB"];
                   
                    
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
                            <label>Date of Birth</label>
                            <input type="date" name="date" class="form-control" value="<?php echo $DOB; ?>">
                            <span class="help-block"><?php echo $DOB_err;?></span>
                        </div>
                        
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="child_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
