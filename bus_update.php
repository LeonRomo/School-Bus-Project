<?php
// Include config file
require_once "bus_config.php";
 
// Define variables and initialize with empty values
$numberplate = $busmodel = "";
$numberplate_err = $busmodel_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate bus number plate
    $input_numberplate = trim($_POST["numberplate"]);
    if(empty($input_numberplate)){
        $numberplate_err = "Please enter the numberplate.";
    }else{
        $numberplate = $input_numberplate;
    }
    
    // Validate bus model
    $input_busmodel = trim($_POST["busmodel"]);
    if(empty($input_busmodel)){
        $busmodel_err = "Please enter the model.";     
    } else{
        $busmodel = $input_busmodel;
    }
    
   
    
    // Check input errors before inserting in database
    if(empty($numberplate_err) && empty($busmodel_err)){
        // Prepare an update statement
        $sql = "UPDATE bus SET bus_number_plate=?, bus_model=? WHERE bus_id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_numberplate, $param_busmodel, $param_id);
            
            // Set parameters
            $param_numberplate = $numberplate;
            $param_busmodel = $busmodel;
           
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: bus_module.php");
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
        $sql = "SELECT * FROM bus WHERE bus_id = ?";
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
                    $numberplate = $row["bus_number_plate"];
                    $busmodel = $row["bus_model"];
                    
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
                        <div class="form-group <?php echo (!empty($numberplate_err)) ? 'has-error' : ''; ?>">
                            <label>Number Plate</label>
                            <input type="text" name="numberplate" class="form-control" value="<?php echo $numberplate; ?>">
                            <span class="help-block"><?php echo $numberplate_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($busmodel_err)) ? 'has-error' : ''; ?>">
                            <label>Bus Model</label>
                            <textarea name="busmodel" class="form-control"><?php echo $busmodel; ?></textarea>
                            <span class="help-block"><?php echo $busmodel_err;?></span>
                        </div>
                        
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="bus_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
