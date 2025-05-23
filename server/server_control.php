<?php
session_start();
// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"])) {
    header("location: server.html");
    exit;
}
?>


<!DOCTYPE html>
<html><body>
<?php
/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

$servername = "localhost";

// REPLACE with your Database name
$dbname = "flavowor_hydroponics_esp_data";

// REPLACE with Database user
$username = "flavowor_hydro";

// REPLACE with Database user password
$password = "~CAlF[=m_{k)";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, value, timestamp, sensor_num FROM TEMPERATURES ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Value</td> 
        <td>Timestamp</td> 
        <td>Sensor #</td> 
      </tr>';
 

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_value = $row["value"];
        $row_timestamp = $row["timestamp"];
        $row_sensor_num = $row["sensor_num"];
        
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_value . '</td> 
                <td>' . $row_timestamp . '</td> 
                <td>' . $row_sensor_num . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>