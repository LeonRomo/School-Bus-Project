<?php
// Include config file
require_once "bus_config.php";
 
// Define variables and initialize with empty values
$numberplate = $busmodel = "";
$numberplate_err = $busmodel_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate numberplate
    $input_numberplate = trim($_POST["numberplate"]);
    if(empty($input_numberplate)){
        $numberplate_err = "Please enter the number plate.";
    } else{
        $numberplate = $input_numberplate;
    }
    
    // Validate bus model
    $input_busmodel = trim($_POST["busmodel"]);
    if(empty($input_busmodel)){
        $busmodel_err = "Please enter the Bus model.";     
    } else{
        $busmodel = $input_busmodel;
    }
    
    

    
    // Check input errors before inserting in database
    if(empty($numberplate_err) && empty($busmodel_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO bus (bus_number_plate, bus_model) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_numberplate, $param_busmodel);
            
            // Set parameters
            $param_numberplate = $numberplate;
            $param_busmodel = $busmodel;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
                        <div class="form-group <?php echo (!empty($numberplate_err)) ? 'has-error' : ''; ?>">
                            <label>Number Plate</label>
                            <input type="text" name="numberplate" class="form-control" value="<?php echo $numberplate; ?>">
                            <span class="help-block"><?php echo $numberplate_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($busmodel_err)) ? 'has-error' : ''; ?>">
                            <label>Bus Model</label>
                            <input type="text" name="busmodel" class="form-control" value="<?php echo $busmodel; ?>">
                            <span class="help-block"><?php echo $busmodel_err;?></span>
                        </div>

                       
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="bus_module.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>