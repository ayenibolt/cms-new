<?php
define('DB_SERVER','eporqep6b4b8ql12.chr7pe7iynqr.eu-west-1.rds.amazonaws.com');
define('DB_USER','od81rp7liegjk1gw');
define('DB_PASS' ,'a2qdjl6p43yi616i');
define('DB_NAME', 'oi47oh3e2efsjwdb');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
