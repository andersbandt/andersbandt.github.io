<?php
session_start();
$host="localhost"; // Host name 
$username="flavowor_1"; // Mysql username 
$password="~@*xwu,Em1QD"; // Mysql password 
$db_name="flavowor_server"; // Database name 
$tbl_name="credentials"; // Table name

// Connect to server and select database.
$con = mysqli_connect("$host", "$username", "$password") or die(mysql_error());
mysqli_select_db($con, "$db_name") or die(mysqli_error());

// Check $username and $password 
if(empty($_POST['username']))
{
    echo "UserName/Password is empty!";
    return false;
}
if(empty($_POST['password']))
{
    echo "Password is empty!";
    return false;
}

// Define $username and $password 
$username=$_POST['username']; 
$password=($_POST['password']);

// To protect MySQL injection (more detail about MySQL injection)
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);

$sql = "SELECT * FROM $tbl_name WHERE username='$username' and password='$password'";
$result = mysqli_query($con, $sql);

// Mysql_num_row is counting table row
$count=mysqli_num_rows($result);
// If result matched $username and $password, table row must be 1 row
if ($count==1) {
                            
    // Store data in session variables
    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;                            
                            
    // Redirect user to welcome page
    header("location: server_control.php");
} else {
    header("location: failed_login.html");
}

ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <title>Login</title>
</head>
<body>
  


  </body>
  </html>