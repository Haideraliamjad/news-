<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "news";
$conn = new mysqli($server,$username,$password,$dbname);
if($conn->connect_error){
    echo "Connection Failed Because of " . $conn->connect_error;
}
?>