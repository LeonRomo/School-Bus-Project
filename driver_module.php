<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Driver Details</h2>
                        <a href="dashboard.php" class="btn btn-success pull-right">Back</a>
                        <a href="driver_report.php" class="btn btn-success pull-right">View Record</a>
                        <a href="driver_add.php" class="btn btn-success pull-right">Add New Driver</a>
                        
                    </div>
                    <?php
                    // Include config file
                    require_once "driver_config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM driver";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                      //  echo "<th>ID</th>";
                                        echo "<th>Firstname</th>";
                                        echo "<th>Lastname</th>";
                                        echo "<th>Mobile number</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Driver Last Login</th>";
                                        echo "<th>Bus Number Plate</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                      //  echo "<td>" . $row['driver_id'] . "</td>";
                                        echo "<td>" . $row['driver_firstName'] . "</td>";
                                        echo "<td>" . $row['driver_lastName'] . "</td>";
                                        echo "<td>" . $row['driver_mobileNumber'] . "</td>";
                                        echo "<td>" . $row['driver_email'] . "</td>";
                                        echo "<td>" . $row['driver_last_login'] . "</td>";
                                        
                                        echo "<td>" . $row['driver_bus_number_plate'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='driver_read.php?id=". $row['driver_id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='driver_update.php?id=". $row['driver_id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='driver_delete.php?id=". $row['driver_id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>