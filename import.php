<?php
/*
* iTech Empires:  How to Import Data from CSV File to MySQL Using PHP Script
* Version: 1.0.0
* Page: Import.PHP
*/

// Database Connection
require 'db_connection.php';

$message = "";
//$ruta = "\\\\\\\\srvperp01\\\\tmp\\\\pp\\\\";
$ruta = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . "cronotc" . DIRECTORY_SEPARATOR;

echo "----------" . $ruta . "<br>";

if (isset($_POST['submit'])) {
    $allowed = array('csv');
    $filename = $_FILES['file']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    echo "-------ext---" . $ext. "<br>";
    echo "-------filename---" . $filename. "<br>";
    
    
    if (!in_array($ext, $allowed)) {
        // show error message
        $message = 'Invalid file type, please use .CSV file!';
    } else {

        move_uploaded_file($_FILES["file"]["tmp_name"], $ruta . $_FILES['file']['name']);

        $file = $ruta . $_FILES['file']['name'];
        echo "-------file---" . $file. "<br>";

	       if ($_FILES["file"]["size"] > 0) 
	       {
	        
	        $file = fopen($fileName, "r");
	        
	        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
	            $sqlInsert = "INSERT into cronotc (id,nombre,horaini,horafin,visible,paquete,placa,color)
	                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4]. "','" . $column[5] . "','" . $column[6] . "')";
	            $result = mysqli_query($conn, $sqlInsert);
	            
	            if (! empty($result)) {
	                $type = "success";
	                $message = "CSV Data Imported into the Database";
	            } else {
	                $type = "error";
	                $message = "Problem in Importing CSV Data";
	            }
	        }
	    }
    
    }
}

echo "-------query---" . $query. "<br>";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Import Data from CSV File to MySQL Tutorial</title>
    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <h2>
        Tutorial: How to Import Data from CSV File to MySQL Using PHP
    </h2>
    <br><br>

    <div class="row">
        <div class="col-md-6 col-md-offset-0">
            <form enctype="multipart/form-data" method="post" action="import.php">
                <div class="form-group">
                    <label for="file">Select .CSV file to Import</label>
                    <input name="file" type="file" class="form-control">
                </div>
                <div class="form-group">
                    <?php echo $message; ?>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Submit"/>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
