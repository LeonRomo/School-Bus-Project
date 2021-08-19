<?php
// Include config file
require_once "parent_config.php";
 
// Define variables and initialize with empty values
$parentid = $childid = "";
$parentid_err = $childid_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate parent_ID
    $input_parentid = trim($_POST["parentid"]);
    if(empty($input_parentid)){
        $parentid_err = "Please enter the parent ID.";
    } elseif(!ctype_digit($input_parentid)){
        $parentid_err = "Please enter a positive integer value.";
    }else{
        $parentid = $input_parentid;
    }
    
    // Validate Child_ID
    $input_childid = trim($_POST["childid"]);
    if(empty($input_childid)){
        $childid_err = "Please enter childid.";     
    } elseif(!ctype_digit($input_childid)){
        $childid_err = "Please enter a positive integer value.";
    }else{
        $childid = $input_childid;
    }
    
    

    
    // Check input errors before inserting in database
    if(empty($parentid_err) && empty($child_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO parent_children (parent_id, child_id) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $param_parentid, $param_childid);
            
            // Set parameters
            $param_parentid = $parentid;
            $param_childid = $childid;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: parent_children_module.php");
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
                        <div class="form-group <?php echo (!empty($parentid_err)) ? 'has-error' : ''; ?>">
                            <label>Parent ID</label>
                            <input type="number" name="parentid" class="form-control" value="<?php echo $parentid; ?>">
                            <span class="help-block"><?php echo $parentid_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($childid_err)) ? 'has-error' : ''; ?>">
                            <label>Child ID</label>
                            <input type="number" name="childid" class="form-control" value="<?php echo $childid; ?>">
                            <span class="help-block"><?php echo $childid_err;?></span>
                        </div>

                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="parent_children_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>