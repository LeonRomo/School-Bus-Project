<?php
// Include config file
require_once "parent_config.php";
 
// Define variables and initialize with empty values
$parentid = $childid = "";
$parentid_err = $childid_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
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
    if(empty($parentid_err) && empty($childid_err)){
        // Prepare an update statement
        $sql = "UPDATE parent_children SET parent_id=?, child_id=? WHERE parent_children_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iii", $param_parentid, $param_childid, $param_id);
            
            // Set parameters
            $param_parentid = $parentid;
            $param_childid = $childid;
           
           
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM parent_children WHERE parent_children_id = ?";
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
                    $parentid = $row["parent_id"];
                    $childid = $row["child_id"];
                    
                    
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
                        
                        
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="parent_children_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
