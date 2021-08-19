<?php  
 function fetch_data()  
 {  
      $output = '';  
      $conn = mysqli_connect("localhost", "root", "", "school_transport");  
      $sql = "SELECT * FROM driver ORDER BY driver_id ASC";  
      $result = mysqli_query($conn, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '<tr>  
                       
                          <td>'.$row["driver_firstName"].'</td>  
                          <td>'.$row["driver_lastName"].'</td>  
                          <td>'.$row["driver_mobileNumber"].'</td>  
                          <td>'.$row["driver_email"].'</td>  
                          <td>'.$row["driver_last_login"].'</td>
                          <td>'.$row["driver_bus_number_plate"].'</td>
                          
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 if(isset($_POST["generate_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Driver Report");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h4 align="center">Driver Report</h4><br /> 
      <table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                 
                <th width="15%">Driver Firstname</th>  
                <th width="15%">Driver Lastname</th>  
                <th width="15%">Driver Mobile Number</th>  
                <th width="20%">Driver Email</th>  
                <th width="30%">Driver Last Login</th>  
                <th width="10%">Bus Number Plate</th>  
           </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('driver-report.pdf', 'I');  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Child Report</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />            
      </head>  
      <body>  
           <br />
           <div class="container">  
                <h4 align="center">Driver Report</h4><br />  
                <div class="table-responsive">  
                    <div class="col-md-12" align="right">
                     <form method="post">  
                          <input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF" />  
                          <a href="driver_module.php" class="btn btn-success pull-right">Back</a>
                     </form>  
                     </div>
                     <br/>
                     <br/>
                     <table class="table table-bordered">  
                     <tr>  
                            
                          <th width="15%">Driver Firstname</th>  
                         <th width="15%">Driver Lastname</th>  
                         <th width="15%">Driver Mobile Number</th>  
                         <th width="30%">Driver Email</th>  
                         <th width="30%">Driver Last Login</th>  
                         <th width="10%">Bus Number Plate</th>  
                    </tr>   
                     <?php  
                     echo fetch_data();  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
</html>